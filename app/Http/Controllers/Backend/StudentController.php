<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Mark;
use App\Registration;
use App\Section;
use App\Student;
use App\Subject;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');

        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }

        $iclass = null;
        $students = [];
        $sections = [];
        $status = '1';

        // get query parameter for filter the fetch
        $class_id = $request->query->get('class',0);
        $section_id = $request->query->get('section',0);
        $acYear = $request->query->get('academic_year',0);
        $status = $request->query->get('status','1');


        $classInfo = null;
        $sectionInfo = null;
        if($class_id){

            if(AppHelper::getInstituteCategory() != 'college') {
                // now check is academic year set or not
                $settings = AppHelper::getAppSettings();
                if(!isset($settings['academic_year']) || (int)($settings['academic_year']) < 1){
                    return redirect()->route('student.index')
                        ->with("error",'Academic year not set yet! Please go to settings and set it.')
                        ->withInput();
                }
                $acYear = $settings['academic_year'];
            }


            //get student
            $students = Registration::where('class_id', $class_id)
                ->where('academic_year_id', $acYear)
                ->where('status', $status)
                ->section($section_id)
                ->with('student')
                ->orderBy('student_id','asc')
                ->get();

            //if section is mention then full this class section list
            if($section_id){
                $sections = Section::where('status', AppHelper::ACTIVE)
                    ->where('class_id', $class_id)
                    ->orderBy('name','asc')
                    ->pluck('name', 'id');

            }

            $iclass = $class_id;

        }

        return view('backend.student.list', compact('students', 'classes', 'iclass', 'sections',
            'section_id', 'academic_years', 'acYear', 'status'
        ));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $student = null;
        $gender = 0;
        $religion = 0;
        $bloodGroup = 0;
        $nationality = 'Bangladeshi';
        $group = 'None';
        $shift = 'Day';
        $regiInfo = null;
        $sections = [];
        $iclass = null;
        $section = null;
        $acYear = null;
        $esubject = null;
        $csubjects = [];
        $ssubjects = [];
        $electiveSubjects = [];
        $selectiveSubjects = [];
        $coreSubjects = [];
        $academic_years = [];
        $classInfo = null;

        // check for institute type and set gender default value
        $settings = AppHelper::getAppSettings();
        if(isset($settings['institute_type'])){
            $gender = intval($settings['institute_type']);
            if ($gender == 3) {
                $gender = 0;
            }
        }

        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }

        $houseList = AppHelper::getHouseList();


        return view('backend.student.add', compact(
            'regiInfo',
            'student',
            'gender',
            'religion',
            'bloodGroup',
            'nationality',
            'classes',
            'sections',
            'group',
            'shift',
            'iclass',
            'section',
            'academic_years',
            'acYear',
            'electiveSubjects',
            'coreSubjects',
            'selectiveSubjects',
            'esubject',
            'csubjects',
            'ssubjects',
            'houseList',
            'classInfo'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo: wrong class section entry student bug fixed.
        //validate form
        $messages = [
            'photo.max' => 'The :attribute size must be under 200kb.',
            'photo.dimensions' => 'The :attribute dimensions min 150 X 150.',
        ];
        $rules = [
            'name' => 'required|min:5|max:255',
            'nick_name' => 'nullable|min:2|max:50',
            'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150',
            'dob' => 'min:10|max:10',
            'gender' => 'required|integer',
            'religion' => 'nullable|integer',
            'blood_group' => 'nullable|integer',
            'nationality' => 'required|max:50',
            'phone_no' => 'nullable|max:15',
            'extra_activity' => 'nullable|max:15',
            'note' => 'nullable|max:500',
            'father_name' => 'nullable|max:255',
            'father_phone_no' => 'nullable|max:15',
            'mother_name' => 'nullable|max:255',
            'mother_phone_no' => 'nullable|max:15',
            'guardian' => 'nullable|max:255',
            'guardian_phone_no' => 'nullable|max:15',
            'present_address' => 'nullable|max:500',
            'permanent_address' => 'required|max:500',
            'card_no' => 'nullable|min:4|max:50',
            'username' => 'nullable|min:5|max:255|unique:users,username',
            'password' => 'nullable|min:6|max:50',
            'email' => 'nullable|email|max:255|unique:students,email',
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'shift' => 'nullable|max:15',
            'roll_no' => 'nullable|integer',
            'board_regi_no' => 'nullable|max:50',
            'core_subjects' => 'required|array',
            'selective_subjects' => 'nullable|array',
            'fourth_subject' => 'nullable|integer',
            'house' => 'nullable|max:100',
            'siblings' => 'nullable|max:255',
            'sms_receive_no' => 'required|integer',

        ];
        //if it college then need another 2 feilds
        if(AppHelper::getInstituteCategory() == 'college') {
            $rules['academic_year'] = 'required|integer';
        }


        $createUser = false;

        if(strlen($request->get('username',''))){
            $rules['email' ] = 'email|max:255|unique:students,email|unique:users,email';
            $createUser = true;

        }

        $this->validate($request, $rules);

        /**
         *  Wrong class and section bug fix code
         */
        $classId = $request->get("class_id",0);
        $sectionId = $request->get("section_id",0);
        $section = Section::where('id', $sectionId)->where('status', AppHelper::ACTIVE)
            ->where('class_id', $classId)->select('id','capacity','class_id')->first();
        if(!$section){
            return redirect()->route('student.create')
                ->with("error", 'Wrong class and section selection!')
                ->withInput();
        }
        //end

        //for max subject validation
        $classInfo = IClass::where('id', $classId)
            ->first();
        if($classInfo->have_selective_subject
            && count($request->get('selective_subjects',[])) > $classInfo->max_selective_subject
        ) {
            return redirect()->route('student.create')
                ->with("error", "Maximum {$classInfo->max_selective_subject} selective subject allowed!")
                ->withInput($request->except(['password','class_id','section_id']));
        }


        if(AppHelper::getInstituteCategory() != 'college') {
            // now check is academic year set or not
            $settings = AppHelper::getAppSettings();
            if (!isset($settings['academic_year']) || (int)($settings['academic_year']) < 1) {
                return redirect()->route('student.create')
                    ->with("error", 'Academic year not set yet! Please go to settings and set it.')
                    ->withInput();
            }

            $acYearId = $settings['academic_year'];
        }
        else {
            $acYearId = $request->get('academic_year');
        }

        //Other validations
        $studentInDesireSection = Registration::where('academic_year_id', $acYearId)
            ->where('class_id', $section->class_id)
            ->where('section_id', $section->id)
            ->count();
        $studentInDesireSection += 1;

        if($studentInDesireSection > $section->capacity){
            return redirect()->route('student.create')
                ->with("error", 'This section is full! Register student in another section.')
                ->withInput();
        }

        $duplicateRollNo = Registration::where('status', AppHelper::ACTIVE)
            ->where('class_id', $classId)
            ->where('academic_year_id', $acYearId)
            ->where('roll_no', $request->get('roll_no', 0))
            ->count();

        if($duplicateRollNo){
            return redirect()->route('student.create')
                ->with("error", 'Roll no already exists!')
                ->withInput($request->except(['roll_no','password']));
        }


        $data = $request->all();
        //card_no manual validation
        if(strlen($data['card_no'])) {
            $cardNoExists = Registration::where('academic_year_id', $acYearId)
                ->where('card_no', $data['card_no'])->count();

            if($cardNoExists){
                return redirect()->route('student.create')
                    ->with("error", 'This card number has been used for another student on this academic year!')
                    ->withInput();
            }
        }


        //fetch core subject from db
        $subjects = Subject::select('id')
            ->where('class_id', $data['class_id'])
            ->where('type', 1) // 1 =core 2= elective , 3 = selective
            ->where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->get()
            ->mapWithKeys(function ($sub) {
                return [$sub->id => ['subject_type' => "1"]];
            })->toArray();

        if (isset($data['selective_subjects'])) {
            foreach ($data['selective_subjects'] as $sub) {
                $subjects[$sub] = ['subject_type' => "3"];
            }
        }

        if (isset($data['fourth_subject'])) {
            $subjects[$data['fourth_subject']] = ['subject_type' => "2"];
        }

        //card_no manual validation
        if(strlen($data['card_no'])) {
            $cardNoExists = Registration::where('academic_year_id', $acYearId)
                ->where('card_no', $data['card_no'])->count();

            if($cardNoExists){
                return redirect()->route('student.create')
                    ->with("error", 'This card number has been used for another student on this academic year!')
                    ->withInput();
            }
        }

        if($data['nationality'] == 'Other'){
            $data['nationality']  = $data['nationality_other'];
        }

        $imgStorePath = "public/student/";
        if($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store($imgStorePath);
            $fileName = basename($storagepath);
            $data['photo'] = $fileName;
        }
        else{
            $data['photo'] = $request->get('oldPhoto','');
        }


        DB::beginTransaction();
        try {
            //now create user
            if ($createUser) {
                $user = User::create(
                    [
                        'name' => $data['name'],
                        'username' => $request->get('username'),
                        'email' => $data['email'],
                        'phone_no' => $data['phone_no'],
                        'password' => bcrypt($request->get('password')),
                        'remember_token' => null,
                    ]
                );
                //now assign the user to role
                UserRole::create(
                    [
                        'user_id' => $user->id,
                        'role_id' => AppHelper::USER_STUDENT
                    ]
                );
                $data['user_id'] = $user->id;
            }
            // now save employee
            $student = Student::create($data);

            $classInfo = IClass::find($data['class_id']);
            $academicYearInfo = AcademicYear::find($acYearId);
            $regiNo = $academicYearInfo->start_date->format('y') . (string)$classInfo->numeric_value;

            $totalStudent = Registration::where('academic_year_id', $academicYearInfo->id)
                ->where('class_id', $classInfo->id)->withTrashed()->count();
            $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);


            $registrationData = [
                'regi_no' => $regiNo,
                'student_id' => $student->id,
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'academic_year_id' => $academicYearInfo->id,
                'roll_no' => $data['roll_no'],
                'shift' => $data['shift'],
                'card_no' => $data['card_no'],
                'board_regi_no' => $data['board_regi_no'],
                'house' => $data['house'] ??  ''
            ];

           $registration =  Registration::create($registrationData);
           $registration->subjects()->sync($subjects);

            // now commit the database
            DB::commit();
            $request->session()->flash('message', "Student registration number is ".$regiNo);

            //now notify the admins about this record
            $msg = $data['name']." student added by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            //invalid dashboard cache
            Cache::forget('studentCount');
            Cache::forget('student_count_by_class');
            Cache::forget('student_count_by_section');

            return redirect()->route('student.create')->with('success', 'Student added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return redirect()->route('student.create')->with("error",$message);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //get student
        $student = Registration::where('id', $id)
            ->with('student')
            ->with('class')
            ->with('section')
            ->with('acYear')
            ->first();

        if(!$student){
            abort(404);
        }

        $username = '';
        if($student->student->user_id){
            $user = User::find($student->student->user_id);
            $username = $user->username;
        }

        //find siblings
        if(strlen($student->student->siblings)){
            $siblingsRegiNumbers = array_map('trim', explode(',', $student->student->siblings));
            if(count($siblingsRegiNumbers)) {
                $siblingStudents = Registration::whereIn('regi_no', $siblingsRegiNumbers)
                    ->with(['info' => function($q){
                        $q->select('id','name');
                    }])
                    ->select('id','student_id')
                    ->get()
                    ->reduce(function ($siblingStudents, $record){
                        $siblingStudents[] = $record->info->name;
                        return $siblingStudents;
                    });

                  $student->student->siblings = $siblingStudents ? implode(',', $siblingStudents) : '';
                }
        }

        return view('backend.student.view', compact('student', 'username'));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiInfo = Registration::find($id);
        if(!$regiInfo){
            abort(404);
        }
        $student =  Student::find($regiInfo->student_id);
        if(!$student){
            abort(404);
        }
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $sections = Section::where('class_id', $regiInfo->class_id)->where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');

        $isCollege = (AppHelper::getInstituteCategory() == 'college');



        $coreSubjects = Subject::select('id', 'name')
            ->where('class_id',$regiInfo->class_id)
            ->sType(1)
            ->where('status', AppHelper::ACTIVE)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');

        //if college then show both subject in feild
        if($isCollege){
            $selectiveSubjects = Subject::select('id', 'name')
                ->where('class_id',$regiInfo->class_id)
                ->sType([2,3])
                ->where('status', AppHelper::ACTIVE)
                ->orderBy('name', 'asc')
                ->pluck('name', 'id');
            $electiveSubjects = $selectiveSubjects;
        }
        else{
            $selectiveSubjects = Subject::select('id', 'name')
                ->where('class_id',$regiInfo->class_id)
                ->sType(3)
                ->where('status', AppHelper::ACTIVE)
                ->orderBy('name', 'asc')
                ->pluck('name', 'id');
            $electiveSubjects = Subject::select('id', 'name')
                ->where('class_id',$regiInfo->class_id)
                ->sType(2)
                ->where('status', AppHelper::ACTIVE)
                ->orderBy('name', 'asc')
                ->pluck('name', 'id');
        }

        $gender = $student->getOriginal('gender');
        $religion = $student->getOriginal('religion');
        $bloodGroup = $student->getOriginal('blood_group');
        $nationality = ($student->nationality != "Bangladeshi") ? "Other" : "";
        $shift = $regiInfo->shift;
        $section = $regiInfo->section_id;
        $iclass = $regiInfo->class_id;
        $classInfo = IClass::where('id', $iclass)
            ->select( 'have_selective_subject', 'max_selective_subject', 'have_elective_subject')
            ->first();

        //student subjects
        $csubjects = [];
        $ssubjects = [];
        $esubject = null;

        foreach ($regiInfo->subjects as $subject){
            if($subject->pivot->subject_type == 1){
                $csubjects[] = $subject->id;
            }
            else if($subject->pivot->subject_type == 2){
                $esubject = $subject->id;
            }
            else if($subject->pivot->subject_type == 3){
                $ssubjects[] = $subject->id;
            }
        }

        if(!count($csubjects)){
            $csubjects = array_keys($coreSubjects->toArray());
        }

        $users = [];
        if(!$student->user_id){
            $users = User::doesnthave('employee')
                ->doesnthave('student')
                ->whereHas('role' , function ($query) {
                    $query->where('role_id', AppHelper::USER_STUDENT);
                })
                ->pluck('name', 'id');
        }

        $houseList = AppHelper::getHouseList();

        return view('backend.student.add', compact(
            'regiInfo',
            'student',
            'gender',
            'religion',
            'bloodGroup',
            'nationality',
            'classes',
            'sections',
            'shift',
            'iclass',
            'section',
            'electiveSubjects',
            'coreSubjects',
            'selectiveSubjects',
            'esubject',
            'csubjects',
            'ssubjects',
            'users',
            'houseList',
            'classInfo'
        ));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $regiInfo = Registration::find($id);
        if(!$regiInfo){
            abort(404);
        }
        $student =  Student::find($regiInfo->student_id);
        if(!$student){
            abort(404);
        }

        //validate form
        $messages = [
            'photo.max' => 'The :attribute size must be under 200kb.',
            'photo.dimensions' => 'The :attribute dimensions min 150 X 150.',
        ];
        $rules = [
            'name' => 'required|min:5|max:255',
            'nick_name' => 'nullable|min:2|max:50',
            'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150',
            'dob' => 'min:10|max:10',
            'gender' => 'required|integer',
            'religion' => 'nullable|integer',
            'blood_group' => 'nullable|integer',
            'nationality' => 'required|max:50',
            'phone_no' => 'nullable|max:15',
            'extra_activity' => 'nullable|max:15',
            'note' => 'nullable|max:500',
            'father_name' => 'nullable|max:255',
            'father_phone_no' => 'nullable|max:15',
            'mother_name' => 'nullable|max:255',
            'mother_phone_no' => 'nullable|max:15',
            'guardian' => 'nullable|max:255',
            'guardian_phone_no' => 'nullable|max:15',
            'present_address' => 'nullable|max:500',
            'permanent_address' => 'required|max:500',
            'card_no' => 'nullable|min:4|max:50',
            'email' => 'nullable|email|max:255|unique:students,email,'.$student->id.'|email|unique:users,email,'.$student->user_id,
//            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'shift' => 'nullable|max:15',
            'roll_no' => 'nullable|integer',
            'board_regi_no' => 'nullable|max:50',
            'core_subjects' => 'required|array',
            'selective_subjects' => 'nullable|array',
            'fourth_subject' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'house' => 'nullable|max:100',
            'siblings' => 'nullable|max:255',
            'sms_receive_no' => 'required|integer',

        ];


        $this->validate($request, $rules);

        //subject update validation check
        $allowSubjectUpdate = true;
        $haveMarks = Mark::where('registration_id', $id)
            ->count();
        if($haveMarks){
            $allowSubjectUpdate = false;
        }

        $data = $request->all();
        //card_no manual validation
        if(strlen($data['card_no'])) {
            $cardNoExists = Registration::where('academic_year_id', $regiInfo->academic_year_id)
                ->where('card_no', $data['card_no'])
                ->where('id', '!=', $regiInfo->id)
                ->count();

            if($cardNoExists){
                return redirect()->back()
                    ->with("error", 'This card number has been used for another student on this academic year!');
            }
        }

        $duplicateRollNo = Registration::where('status', AppHelper::ACTIVE)
            ->where('class_id', $regiInfo->class_id)
            ->where('academic_year_id', $regiInfo->academic_year_id)
            ->where('id', '!=', $regiInfo->id)
            ->where('roll_no', $request->get('roll_no', 0))
            ->count();

        if($duplicateRollNo){
            return redirect()->back()
                ->with("error", 'Roll no already exists!');
        }

        //for max subject validation
        $classInfo = IClass::where('id', $regiInfo->class_id)
            ->first();
        if($classInfo->have_selective_subject
            && count($request->get('selective_subjects',[])) > $classInfo->max_selective_subject
        ) {
            return redirect()->back()
                ->with("error", "Maximum {$classInfo->max_selective_subject} subject allowed");
        }
        //validation end

        //fetch core subject from db
        $subjects = [];
        $oldSubjects = [];
        if($allowSubjectUpdate) {
            $subjects = Subject::select('id', 'type as sub_type')
                ->where('class_id', $regiInfo->class_id)
                ->where('type', 1)// 1 =core 2= elective , 3 = selective
                ->where('status', AppHelper::ACTIVE)
                ->orderBy('order', 'asc')
                ->get()
                ->mapWithKeys(function ($sub) {
                    return [$sub->id => ['subject_type' => "1"]];
                })->toArray();

            if (isset($data['selective_subjects'])) {
                foreach ($data['selective_subjects'] as $sub) {
                    $subjects[$sub] = ['subject_type' => "3"];
                }
            }

            if (isset($data['fourth_subject'])) {
                $subjects[$data['fourth_subject']] = ['subject_type' => "2"];
            }

            //fetch old subjects for this student
            $oldSubjects = $regiInfo->subjects->map(function ($subject){
                return [
                    "id" => $subject->id,
                    "name" => $subject->name,
                    "s_type" => $subject->getOriginal('type'),
                    "type"   => $subject->pivot->subject_type,
                ];
            });
        }

        if($data['nationality'] == 'Other'){
            $data['nationality']  = $data['nationality_other'];
        }

        $imgStorePath = "public/student/";
        if($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store($imgStorePath);
            $fileName = basename($storagepath);
            $data['photo'] = $fileName;

            //if file change then delete old one
            $oldFile = $request->get('oldPhoto','');
            if( $oldFile != ''){
                $file_path = $imgStorePath.'/'.$oldFile;
                Storage::delete($file_path);
            }
        }
        else{
            $data['photo'] = $request->get('oldPhoto','');
        }



        $registrationData = [
//            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'roll_no' => $data['roll_no'],
            'shift' => $data['shift'],
            'card_no' => $data['card_no'],
            'board_regi_no' => $data['board_regi_no'],
            'house' => $data['house'] ??  ''
        ];

        // now check if student academic information changed, if so then log it
        $isChanged = false;
        $logData = [];
        $timeNow = Carbon::now();
        if($regiInfo->section_id != $data['section_id']){
            $isChanged = true;
            $logData[] = [
                'student_id' => $regiInfo->student_id,
                'academic_year_id' => $regiInfo->academic_year_id,
                'meta_key' => 'section',
                'meta_value' => $regiInfo->section_id,
                'created_at' => $timeNow,

            ];
        }
        if($regiInfo->roll_no != $data['roll_no']){
            $isChanged = true;
            $logData[] = [
                'student_id' => $regiInfo->student_id,
                'academic_year_id' => $regiInfo->academic_year_id,
                'meta_key' => 'roll no',
                'meta_value' => $regiInfo->roll_no,
                'created_at' => $timeNow,

            ];
        }


        if($regiInfo->shift != $data['shift']){
            $isChanged = true;
            $logData[] = [
                'student_id' => $regiInfo->student_id,
                'academic_year_id' => $regiInfo->academic_year_id,
                'meta_key' => 'shift',
                'meta_value' => $regiInfo->shift,
                'created_at' => $timeNow,

            ];
        }

        if($regiInfo->card_no != $data['card_no']){
            $isChanged = true;
            $logData[] = [
                'student_id' => $regiInfo->student_id,
                'academic_year_id' => $regiInfo->academic_year_id,
                'meta_key' => 'card no',
                'meta_value' => $regiInfo->card_no,
                'created_at' => $timeNow,

            ];
        }
        if($regiInfo->board_regi_no != $data['board_regi_no']){
            $isChanged = true;
            $logData[] = [
                'student_id' => $regiInfo->student_id,
                'academic_year_id' => $regiInfo->academic_year_id,
                'meta_key' => 'board regi no',
                'meta_value' => $regiInfo->board_regi_no,
                'created_at' => $timeNow,

            ];
        }


        $message = 'Something went wrong!';
        DB::beginTransaction();
        try {

            $messageType = "success";
            $message = "Student updated!";

            // save registration data
            $regiInfo->fill($registrationData);
            $regiInfo->save();

            //
            if(!$student->user_id && $request->get('user_id', 0)){
                $data['user_id'] = $request->get('user_id');
            }


            // now save student
            $student->fill($data);
            if(($student->isDirty('email') || $student->isDirty('phone_no'))
                && ($student->user_id || isset($data['user_id']))){
                $userId = $data['user_id'] ?? $student->user_id;
                $user = User::where('id', $userId)->first();
                $user->email = $data['email'];
                $user->phone_no = $data['phone_no'];
                $user->save();
            }
            $student->save();

            if($allowSubjectUpdate) {
                $regiInfo->subjects()->sync($subjects);
                DB::table('st_subjects_log')->insert([
                    'registration_id' => $regiInfo->id,
                    'log' => json_encode($oldSubjects),
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
            else{
                $messageType = "warning";
                $message = "Student updated. But subjects was not updated, because have exam marks.";
            }

            //if have changes then insert log
            if($isChanged){
                DB::table('student_info_log')->insert($logData);
            }



            // now commit the database
            DB::commit();


            return redirect()->route('student.index', ['class' => $regiInfo->class_id, 'section'=> $regiInfo->section_id, 'academic_year' => $regiInfo->academic_year_id])->with($messageType, $message);


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
//            dd($message);
        }

        return redirect()->route('student.edit', $regiInfo->id)->with("error",$message);;



    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registration = Registration::find($id);
        if(!$registration){
            abort(404);
        }
        $haveStudent =  Registration::where('student_id',$registration->student_id)->count();

        $message = 'Something went wrong!';
        DB::beginTransaction();
        try {

            $registration->delete();

            $student = Student::find($registration->student_id);

            if(!$haveStudent) {
                $student->delete();
                if ($student->user_id) {
                    $user = User::find($student->user_id);
                    $user->delete();
                }
            }
            DB::commit();


            //now notify the admins about this record
            $msg = $student->name." student deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end
            //invalid dashboard cache
            Cache::forget('studentCount');
            Cache::forget('student_count_by_class');
            Cache::forget('student_count_by_section');

            return redirect()->route('student.index')->with('success', 'Student deleted.');

        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
        }
        return redirect()->route('student.index')->with('error', $message);

    }

    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $registration = Registration::find($id);
        if(!$registration){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }
        $student =  Student::find($registration->student_id);
        if(!$student){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $student->status = (string)$request->get('status');
        $registration->status = (string)$request->get('status');
        if($student->user_id){
            $user = User::find($student->user_id);
            $user->status = (string)$request->get('status');
        }

        $message = 'Something went wrong!';
        DB::beginTransaction();
        try {

            $registration->save();
            $student->save();
            if($student->user_id) {
                $user->save();
            }
            DB::commit();

            return [
                'success' => true,
                'message' => 'Status updated.'
            ];


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
        }

        return [
            'success' => false,
            'message' => $message
        ];


    }

    /**
     * Get student list by filters
     */
    public function studentListByFitler(Request $request) {
        $classId = $request->query->get('class',0);
        $sectionId = $request->query->get('section',0);
        $acYear = $request->query->get('academic_year',0);
        $rollNo = $request->query->get('roll_no','');
        $regiNo = $request->query->get('regi_no','');

        if(AppHelper::getInstituteCategory() != 'college') {
            $acYear = AppHelper::getAcademicYear();
        }

        $students = Registration::if($acYear, 'academic_year_id', '=' , $acYear)
            ->if($classId, 'class_id', '=' ,$classId)
            ->if($sectionId, 'section_id', '=', $sectionId)
            ->if(strlen($regiNo), 'regi_no', '=', $regiNo)
            ->if(strlen($rollNo), 'roll_no', '=', $rollNo)
            ->where('status', AppHelper::ACTIVE)
            ->where('is_promoted', '0')
            ->with(['student' => function ($query) {
                $query->select('name','id');
            }])
            ->select('id','roll_no','regi_no','student_id')
            ->orderBy('roll_no','asc')
            ->get();

        return response()->json($students);

    }
}
