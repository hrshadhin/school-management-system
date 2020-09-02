<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\AppMeta;
use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Employee;
use App\Section;
use Illuminate\Support\Facades\DB;

class DemoAppDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncate previous data
        echo PHP_EOL, 'deleting old data.....';
        $this->deletePreviousData();

        //some user with role
        echo PHP_EOL , 'seeding users...';
        $this->userData();

        //seed academic year
        echo PHP_EOL , 'seeding academic year...';
        $this->academicYearData();

        //seed common settings
        echo PHP_EOL , 'seeding institute settings...';
        $this->instituteSettingsData();

        //seed class
        echo PHP_EOL , 'seeding class...';
        $this->classData();

        //seed teacher
        echo PHP_EOL , 'seeding teacher...';
        $this->teacherData();

        //seed teacher
        echo PHP_EOL , 'seeding employee...';
        $this->employeeData();

        //seed section
        echo PHP_EOL , 'seeding section...';
        $this->sectionData();

        //seed subject
        echo PHP_EOL , 'seeding subject...';
        $this->subjectData();

        //seed student
        echo PHP_EOL , 'seeding student...';
        $this->studentData();

        //seed student attendance
        echo PHP_EOL , 'seeding student attendance...';
        $this->studentAttendance();

        //seed employee attendance
        echo PHP_EOL , 'seeding employee attendance...';
        $this->employeeAttendance();

        //leave and work out side data
        echo PHP_EOL , 'seeding leave...';
        $this->leave();

        //seed exam
        echo PHP_EOL , 'seeding exam...';
        $this->examData();

        //seed grade
        echo PHP_EOL , 'seeding marking grade...';
        $this->gradeData();

        //seed exam rules
        echo PHP_EOL , 'seeding exam rules...';
        $this->examRulesData();

        //seed exam marks
        echo PHP_EOL , 'seeding exam marks...';
        $this->examMarksData();

        //seed exam marks
        echo PHP_EOL , 'seeding exam result...', PHP_EOL;
        $this->generateResult();

    }


    private function deletePreviousData(){
        /***
         * This code is MYSQL specific
         */
        \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks=0");
        $this->deleteUserData();
        AcademicYear::truncate();
        AppMeta::truncate();
        IClass::truncate();
        Employee::truncate();
        Section::truncate();
        \App\Subject::truncate();
        \App\Student::truncate();
        \App\Registration::truncate();
        \App\StudentAttendance::truncate();
        \App\EmployeeAttendance::truncate();
        \App\Exam::truncate();
        \App\Grade::truncate();
        \App\ExamRule::truncate();
        \App\Mark::truncate();
        \App\Result::truncate();
        \App\Leave::truncate();
        \Illuminate\Support\Facades\DB::table('result_publish')->truncate();
        \Illuminate\Support\Facades\DB::table('result_combines')->truncate();
        \Illuminate\Support\Facades\DB::table('teacher_subjects')->truncate();
        \Illuminate\Support\Facades\DB::table('student_subjects')->truncate();
        \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks=1");

        //delete images
        $storagePath = storage_path('app/public');
        $storagePath2 = storage_path('app');
        $dirs = [
            $storagePath.'/admission',
            $storagePath.'/employee',
            $storagePath.'/invoice',
            $storagePath.'/leave',
            $storagePath.'/logo',
            $storagePath.'/report',
            $storagePath.'/student',
            $storagePath.'/work_outside',
            $storagePath2.'/student-attendance',
            $storagePath2.'/employee-attendance',
        ];

        foreach ($dirs as $dir){
            system("rm -rf ".escapeshellarg($dir));
        }
    }

    private function userData(){
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $users = factory(App\User::class, 3)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);
        $users->each(function ($user) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $user->id,
                'role_id' => rand(2,7),
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });
    }

    private function deleteUserData(){
        $userIds = \App\UserRole::where('role_id','!=', AppHelper::USER_ADMIN)->pluck('user_id');
        DB::table('users_permissions')->whereIn('user_id', $userIds)->delete();
        DB::table('user_roles')->whereIn('user_id', $userIds)->delete();
        DB::table('users')->whereIn('id', $userIds)->delete();

    }

    private function academicYearData(){
        $data['title'] = date('Y');
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', '01/01/'.date('Y'));;
        $data['end_date'] = Carbon::createFromFormat('d/m/Y', '31/12/'.date('Y'));
        $data['status'] = '1';

        AcademicYear::create($data);
    }

    private function instituteSettingsData()
    {
        $originFilePath = resource_path('assets/backend/images/');
        $destinationPath = storage_path('app').'/public/logo/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileName = 'logo-md.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['logo'] = $fileName;

        $fileName = 'logo-xs.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['logo_small'] = $fileName;

        $fileName = 'favicon.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['favicon'] = $fileName;


        $data['name'] = 'CloudSchool BD';
        $data['short_name'] = 'CSBD';
        $data['establish'] = '2010';
        $data['website_link'] = 'http://cloudschoolbd.com';
        $data['email'] = 'info@cloudschoolbd.com';
        $data['phone_no'] = '+8801xxxxxxxxx';
        $data['address'] = 'Dhanmondi, Dhaka-1207';

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        //now create
        AppMeta::create([
            'meta_key' => 'institute_settings',
            'meta_value' => json_encode($data),
            'created_by' => $created_by,
            'created_at' => $created_at
        ]);

        if(AppHelper::getInstituteCategory() != 'college') {
            AppMeta::create([
                'meta_key' => 'academic_year',
                'meta_value' => 1,
                'created_by' => $created_by,
                'created_at' => $created_at
            ]);
        }

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
        $shiftData = [
            'Morning' => [
                'start' => '08:00 am',
                'end' => '01:00 pm',
            ],
            'Day' => [
                'start' => '02:00 pm',
                'end' => '07:00 pm',
            ],
            'Evening' => [
                'start' => '12:00 am',
                'end' => '12:00 am',
            ]
        ];
        $insertData = [
            ['meta_key' => 'frontend_website' ,'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'language', 'meta_value' =>  'en', 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'disable_language', 'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'institute_type', 'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'shift_data', 'meta_value' => json_encode($shiftData), 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'weekends', 'meta_value' => json_encode([5]), 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'week_start_day', 'meta_value' => 6, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'week_end_day', 'meta_value' => 5, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'total_casual_leave', 'meta_value' => 14, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'total_sick_leave', 'meta_value' => 10, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'total_maternity_leave', 'meta_value' => 90, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'total_special_leave', 'meta_value' => 5, 'created_by' => $created_by, 'created_at' => $created_at],
            ['meta_key' => 'board_name', 'meta_value' => 'Dhaka', 'created_by' => $created_by, 'created_at' => $created_at]
        ];

        //now crate
        AppMeta::insert($insertData);

        //invalid previous cache
        \Illuminate\Support\Facades\Cache::forget('app_settings');
    }



    private function classData(){
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $insertData = [
            [
                'name' => 'One',
                'numeric_value' => 1,
                'order' => 1,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Two',
                'numeric_value' => 2,
                'order' => 2,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                'have_selective_subject' => true,
                'max_selective_subject' => 2,
                'have_elective_subject' => true,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Three',
                'numeric_value' => 3,
                'order' => 3,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Four',
                'numeric_value' => 4,
                'order' => 4,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Five',
                'numeric_value' => 5,
                'order' => 5,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Six',
                'numeric_value' => 6,
                'order' => 6,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Seven',
                'numeric_value' => 7,
                'order' => 7,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Eight',
                'numeric_value' => 8,
                'order' => 8,
                'group' => 'None',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Nine Science',
                'numeric_value' => 90,
                'order' => 9,
                'group' => 'Science',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],
            [
                'name' => 'Nine Humanities',
                'numeric_value' => 91,
                'order' => 10,
                'group' => 'Humanities',
                'status' => '1',
                'note' => 'demo test',
                 'have_selective_subject' => false,
                'max_selective_subject' => null,
                'have_elective_subject' => false,
                'created_by' => $created_by,
                'created_at' => $created_at
            ],

        ];

        IClass::insert($insertData);
    }

    private function teacherData() {

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $insHeadDesignation = 7;
        if(AppHelper::getInstituteCategory() == "college"){
            $insHeadDesignation = 1;
        }

        $instituteHead = factory(App\Employee::class, 1)
            ->create(['designation' => $insHeadDesignation,'created_by' => $created_by,'created_at' => $created_at]);

        $instituteHead->each(function ($teacher) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $teacher->user_id,
                'role_id' => AppHelper::USER_TEACHER,
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });

        $teachers = factory(App\Employee::class, 5)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $teachers->each(function ($teacher) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $teacher->user_id,
                'role_id' => AppHelper::USER_TEACHER,
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });


    }
    private function employeeData() {

        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $employee = factory(App\Employee::class, 1)->create(['role_id' => 5, 'created_by' => $created_by,'created_at' => $created_at])->first();
        \App\UserRole::create(['user_id' => $employee->user_id, 'role_id' => $employee->role_id, 'created_by' => $created_by, 'created_at' => $created_at]);

        $employee = factory(App\Employee::class, 1)->create(['role_id' => 6, 'created_by' => $created_by,'created_at' => $created_at])->first();
        \App\UserRole::create(['user_id' => $employee->user_id, 'role_id' => $employee->role_id, 'created_by' => $created_by, 'created_at' => $created_at]);

        $employee = factory(App\Employee::class, 1)->create(['role_id' => 7, 'created_by' => $created_by,'created_at' => $created_at])->first();
        \App\UserRole::create(['user_id' => $employee->user_id, 'role_id' => $employee->role_id, 'created_by' => $created_by, 'created_at' => $created_at]);

    }

    private function sectionData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $section = factory(App\Section::class, 5)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class, 2)
            ->create(['class_id'=> 2, 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class, 2)
            ->create(['class_id'=> 3, 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class, 2)
            ->create(['class_id'=> 4, 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class)
            ->create(['class_id'=> 1, 'name' => 'A', 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class)
            ->create(['class_id'=> 1, 'name' => 'B', 'created_by' => $created_by,'created_at' => $created_at]);

        $section = factory(App\Section::class)
            ->create(['class_id'=> 1, 'name' => 'C', 'created_by' => $created_by,'created_at' => $created_at]);
    }

    private function subjectData()
    {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));

        $subject = factory(App\Subject::class, 10)
            ->create(['created_by' => $created_by, 'created_at' => $created_at]);

        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 1, 'type' => 1, 'name' => 'Bangla 1st', 'code' => '101', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 1, 'type' => 1, 'name' => 'Bangla 2nd', 'code' => '102', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 1, 'type' => 1, 'name' => 'English 1st', 'code' => '107', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 1, 'type' => 1, 'name' => 'English 2nd', 'code' => '108', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 1, 'type' => 1, 'name' => 'Math', 'code' => '111', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 1, 'type' => 1, 'name' => 'Computer', 'code' => '112', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        echo PHP_EOL."seeding class two subjects";
        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 2, 'type' => 1, 'name' => 'Bangla 1st', 'code' => '101', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 2, 'type' => 3, 'name' => 'Magic Study', 'code' => '102', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 2, 'type' => 1, 'name' => 'English 1st', 'code' => '107', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 2, 'type' => 3, 'name' => 'Drawing', 'code' => '108', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 2, 'type' => 1, 'name' => 'Math', 'code' => '111', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });

        $subject = factory(App\Subject::class, 1)
            ->create(['class_id' => 2, 'type' => 2, 'name' => 'Computer', 'code' => '112', 'created_by' => $created_by, 'created_at' => $created_at]);
        $subject->each(function ($sub) {
            $teacher = App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first();
            // Create Pivot
            $sub->teachers()->attach($teacher->id);
        });


    }


    private function studentData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $students = factory(App\Student::class, 15)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $students->each(function ($student) use($created_at, $created_by) {
            \App\UserRole::create([
                'user_id' => $student->user_id,
                'role_id' => AppHelper::USER_STUDENT,
                'created_by' => $created_by,
                'created_at' => $created_at

            ]);
        });

        //now register student to classes

        $studentIds = $students->pluck('id');
        $academicYearInfo = AcademicYear::where('id',1)->first();

        $class1Info = IClass::where('id', 1)->first();
        $class1Sections = Section::where('class_id', $class1Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');

        $class2Info = IClass::where('id', 2)->first();
        $class2Sections = Section::where('class_id', $class2Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');

        $class3Info = IClass::where('id', 3)->first();
        $class3Sections = Section::where('class_id', $class3Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');

        $class4Info = IClass::where('id', 4)->first();
        $class4Sections = Section::where('class_id', $class4Info->id)->orderBy('name', 'asc')->take(1)->pluck('id');


        $counter = 1;
        foreach ($studentIds as $studentId){

            //distribute 5 student for class id 1
            if($counter <= 5){

                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class1Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class1Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class1Info->id,
                    'section_id' => $class1Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];


            }
            //distribute 4 student for class id 2
            elseif($counter > 5 && $counter <= 9){
                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class2Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class2Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class2Info->id,
                    'section_id' => $class2Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];

            }
            //distribute 3 student for class id 3
            elseif($counter > 9 && $counter <= 12){
                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class3Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class3Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class3Info->id,
                    'section_id' => $class3Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];
            }
            //distribute 3 student for class id 4
            else{

                $regiNo = $academicYearInfo->start_date->format('y') . (string)$class4Info->numeric_value;
                $totalStudent = \App\Registration::where('academic_year_id', $academicYearInfo->id)
                    ->where('class_id', $class4Info->id)->withTrashed()->count();
                $regiNo .= str_pad(++$totalStudent,3,'0',STR_PAD_LEFT);

                $registrationData = [
                    'regi_no' => $regiNo,
                    'student_id' => $studentId,
                    'class_id' => $class4Info->id,
                    'section_id' => $class4Sections[0],
                    'academic_year_id' => $academicYearInfo->id,
                    'roll_no' => $studentId,
                    'shift'    => 'Morning',
                    'card_no'    => null,
                    'board_regi_no' => null,
                    'house' => null,
                    'status' => '1',
                    'created_by' => $created_by,
                    'created_at' => $created_at
                ];

            }

            \App\Registration::insert([$registrationData]);
            $counter++;
        }

        //now assign subject to class 1 students
        $students = \App\Registration::where('class_id', 1)->get();
        $subjects = \App\Subject::where('class_id', 1)->get()->mapWithKeys(function ($sub) {
            return [$sub->id => ['subject_type' => $sub->getOriginal('type')]];
        })->toArray();
        
        foreach ($students as $student){
            $student->subjects()->sync($subjects);
        }


    }

    private function studentAttendance() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $endDate = $created_at->copy();
        $startDate = $created_at->copy()->subDays(15);

        $wekends = AppHelper::getAppSettings('weekends', true);
        if($wekends){
            $wekends = json_decode($wekends);
        }
        else{
            $wekends = [];
        }

        $attendanceDates = AppHelper::generateDateRangeForReport($startDate, $endDate, true, $wekends, true);

        //fetch institute shift running times
        $shiftData = AppHelper::getAppSettings('shift_data', true);
        if($shiftData){
            $shiftData = json_decode($shiftData, true);
        }

        $students = \App\Registration::where('class_id', 1)->where('academic_year_id', 1)
            ->get(['id', 'shift'])
            ->reduce(function ($students, $student) {
                $students[$student->id] = $student->shift;
                return $students;
            });

        $attendances = [];
        foreach ($attendanceDates as $attendanceDate => $value) {
            $shiftRuningTimes = [];
            foreach ($shiftData as $shift => $times) {
                $shiftRuningTimes[$shift] = [
                    'start' => Carbon::createFromFormat('Y-m-d h:i a', $attendanceDate . ' ' . $times['start']),
                    'end' => Carbon::createFromFormat('Y-m-d h:i a', $attendanceDate . ' ' . $times['end'])
                ];
            }

            foreach ($students as $studentId => $shift) {
                $isPresent = rand(0,1);
                if($isPresent) {
                    $inTime = $shiftRuningTimes[$shift]['start'];
                    $outTime = $shiftRuningTimes[$shift]['end'];
                }
                else{
                    $inTime = Carbon::createFromFormat('Y-m-d H:i:s', $attendanceDate . ' 00:00:00');
                    $outTime = $inTime;
                }
                $timeDiff  = $inTime->diff($outTime)->format('%H:%I');

                $attendances[] = [
                    "academic_year_id" => 1,
                    "class_id" => 1,
                    "registration_id" => $studentId,
                    "attendance_date" => $attendanceDate,
                    "in_time" => $inTime,
                    "out_time" => $outTime,
                    "staying_hour" => $timeDiff,
                    "status" => '',
                    "present" => strval($isPresent),
                    "created_at" => $created_at,
                    "created_by" => $created_by,
                ];
            }

        }

        //now insert into db
        \App\StudentAttendance::insert($attendances);
    }

    private function employeeAttendance() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $endDate = $created_at->copy();
        $startDate = $created_at->copy()->subDays(15);

        $wekends = AppHelper::getAppSettings('weekends', true);
        if($wekends){
            $wekends = json_decode($wekends);
        }
        else{
            $wekends = [];
        }

        $attendanceDates = AppHelper::generateDateRangeForReport($startDate, $endDate, true, $wekends, true);

        //fetch institute shift running times
        $shiftData = AppHelper::getAppSettings('shift_data', true);
        if($shiftData){
            $shiftData = json_decode($shiftData, true);
        }

        //fetch employee working hours
        $employees = Employee::where('status', AppHelper::ACTIVE)->get()->reduce(function ($employees, $employee) {
            $employees[$employee->id] = [
                'in_time' => $employee->getOriginal('duty_start'),
                'out_time' => $employee->getOriginal('duty_end')
            ];
            return $employees;
        });

        $attendances = [];
        foreach ($attendanceDates as $attendanceDate => $value) {

            foreach ($employees as $employeeId => $employeeShift) {
                $isPresent = rand(0,1);
                if($isPresent) {
                    $inTime = Carbon::createFromFormat('Y-m-d h:i a', $attendanceDate . ' ' . $shiftData['Morning']['start']);
                    $outTime = Carbon::createFromFormat('Y-m-d h:i a', $attendanceDate . ' ' . $shiftData['Morning']['end']);
                }
                else{
                    $inTime = Carbon::createFromFormat('Y-m-d H:i:s', $attendanceDate . ' 00:00:00');
                    $outTime = $inTime;
                }
                $timeDiff  = $inTime->diff($outTime)->format('%H:%I');

                $attendances[] = [
                    "employee_id" => $employeeId,
                    "attendance_date" => $attendanceDate,
                    "in_time" => $inTime,
                    "out_time" => $outTime,
                    "working_hour" => $timeDiff,
                    "status" => '',
                    "present"   => strval($isPresent),
                    "created_at" => $created_at,
                    "created_by" => $created_by,
                ];

            }

        }

        //now insert into db
        \App\EmployeeAttendance::insert($attendances);





    }

    private function leave() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));
        $leaves = factory(App\Leave::class, 5)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

    }

    private function examData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $exmas = factory(App\Exam::class, 10)
            ->create(['created_by' => $created_by,'created_at' => $created_at]);

        $exam = factory(App\Exam::class)
            ->create([
                'class_id'=> 1,
                'name' => '1st Term Exam',
                'elective_subject_point_addition' => 0,
                'marks_distribution_types' => json_encode([1,2,7]),
                'open_for_marks_entry' => true,
                'created_by' => $created_by,
                'created_at' => $created_at
            ]);

        $exam = factory(App\Exam::class)
            ->create([
                'class_id'=> 1,
                'name' => 'Mid Term Exam',
                'elective_subject_point_addition' => 2.00,
                'marks_distribution_types' => json_encode([1,2,5]),
                'created_by' => $created_by,
                'created_at' => $created_at
            ]);

        $exam = factory(App\Exam::class)
            ->create([
                'class_id'=> 1,
                'name' => 'Final Exam',
                'elective_subject_point_addition' => 0,
                'marks_distribution_types' => json_encode([1,2,7]),
                'created_by' => $created_by,
                'created_at' => $created_at
            ]);

    }

    private function gradeData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $grades = [
            [
                'name' => '100 Marks',
                'rules' => json_encode([
                    [
                        'grade' => 1,//AppHelper::GRADE_TYPES
                        'point' => 5,
                        'marks_from' => 80,
                        'marks_upto' => 100
                    ],[
                        'grade' => 2,
                        'point' => 4,
                        'marks_from' => 70,
                        'marks_upto' => 79
                    ],[
                        'grade' => 3,
                        'point' => 3.5,
                        'marks_from' => 60,
                        'marks_upto' => 69
                    ],[
                        'grade' => 4,
                        'point' => 3,
                        'marks_from' => 50,
                        'marks_upto' => 59
                    ],[
                        'grade' => 5,
                        'point' => 2,
                        'marks_from' => 40,
                        'marks_upto' => 49
                    ],[
                        'grade' => 6,
                        'point' => 1,
                        'marks_from' => 33,
                        'marks_upto' => 39
                    ],
                    [
                        'grade' => 7,
                        'point' => 0,
                        'marks_from' => 0,
                        'marks_upto' => 32
                    ]
                ]),
                'created_at' => $created_at,
                'created_by' => $created_by
            ],
            [
                'name' => '50 Marks',
                'rules' => json_encode([
                    [
                        'grade' => 1,
                        'point' => 5,
                        'marks_from' => 40,
                        'marks_upto' => 50
                    ],[
                        'grade' => 2,
                        'point' => 4,
                        'marks_from' => 35,
                        'marks_upto' => 39
                    ],[
                        'grade' => 3,
                        'point' => 3.5,
                        'marks_from' => 30,
                        'marks_upto' => 34
                    ],[
                        'grade' => 4,
                        'point' => 3,
                        'marks_from' => 25,
                        'marks_upto' => 29
                    ],[
                        'grade' => 5,
                        'point' => 2,
                        'marks_from' => 20,
                        'marks_upto' => 24
                    ],[
                        'grade' => 6,
                        'point' => 1,
                        'marks_from' => 17,
                        'marks_upto' => 19
                    ],
                    [
                        'grade' => 7,
                        'point' => 0,
                        'marks_from' => 0,
                        'marks_upto' => 16
                    ]
                ]),
                'created_at' => $created_at,
                'created_by' => $created_by
            ]
        ];

        \App\Grade::insert($grades);

        //set default result system
        $insertData = ['meta_key' => 'result_default_grade_id' ,'meta_value' => 1, 'created_by' => $created_by, 'created_at' => $created_at];
        AppMeta::insert($insertData);

    }

    private function examRulesData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $class_id = 1;

        $subjects = \App\Subject::where('class_id', $class_id)
            ->orderBy('code', 'asc')
            ->get()
            ->reduce(function ($subjects, $record){
                $subjects[$record->code] = $record->id;
                return $subjects;
            });

        $exam = \App\Exam::where('class_id', $class_id)->orderBy('id', 'asc')->first();
//         $marksDistributions = json_decode($exam->marks_distribution_types);
//           1 2 7

        //for bangla 1st
        $rules[] = [
            'class_id' => $class_id,
            'subject_id' => $subjects[101],
            'exam_id'  => $exam->id,
            'grade_id' => 1,
            'combine_subject_id' => $subjects[102],
            'marks_distribution' => json_encode([
                ['type' => 1, 'total_marks' => 70, 'pass_marks' => 0],
                ['type' => 2, 'total_marks' => 30, 'pass_marks' => 0],
                ['type' => 7, 'total_marks' => 0, 'pass_marks' => 0],
            ]),
            'passing_rule' => 1,
            'total_exam_marks' => 100,
            'over_all_pass'    => 33,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];
        //bangla 2nd
        $rules[] = [
            'class_id' => $class_id,
            'subject_id' => $subjects[102],
            'exam_id'  => $exam->id,
            'grade_id' => 2,
            'combine_subject_id' => null,
            'marks_distribution' => json_encode([
                ['type' => 1, 'total_marks' => 35, 'pass_marks' => 0],
                ['type' => 2, 'total_marks' => 15, 'pass_marks' => 0],
                ['type' => 7, 'total_marks' => 0, 'pass_marks' => 0],
            ]),
            'passing_rule' => 1,
            'total_exam_marks' => 50,
            'over_all_pass'    => 17,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];

        //english 1st
        $rules[] = [
            'class_id' => $class_id,
            'subject_id' => $subjects[107],
            'exam_id'  => $exam->id,
            'grade_id' => 1,
            'combine_subject_id' => $subjects[108],
            'marks_distribution' => json_encode([
                ['type' => 1, 'total_marks' => 70, 'pass_marks' => 0],
                ['type' => 2, 'total_marks' => 30, 'pass_marks' => 0],
                ['type' => 7, 'total_marks' => 0, 'pass_marks' => 0],
            ]),
            'passing_rule' => 1,
            'total_exam_marks' => 100,
            'over_all_pass'    => 33,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];
        //english 2nd
        $rules[] = [
            'class_id' => $class_id,
            'subject_id' => $subjects[108],
            'exam_id'  => $exam->id,
            'grade_id' => 2,
            'combine_subject_id' => null,
            'marks_distribution' => json_encode([
                ['type' => 1, 'total_marks' => 35, 'pass_marks' => 0],
                ['type' => 2, 'total_marks' => 15, 'pass_marks' => 0],
                ['type' => 7, 'total_marks' => 0, 'pass_marks' => 0],
            ]),
            'passing_rule' => 1,
            'total_exam_marks' => 50,
            'over_all_pass'    => 17,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];

        //math
        $rules[] = [
            'class_id' => $class_id,
            'subject_id' => $subjects[111],
            'exam_id'  => $exam->id,
            'grade_id' => 1,
            'combine_subject_id' => null,
            'marks_distribution' => json_encode([
                ['type' => 1, 'total_marks' => 70, 'pass_marks' => 25],
                ['type' => 2, 'total_marks' => 30, 'pass_marks' => 10],
                ['type' => 7, 'total_marks' => 0, 'pass_marks' => 0],
            ]),
            'passing_rule' => 2,
            'total_exam_marks' => 100,
            'over_all_pass'    => 0,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];

        //computer
        $rules[] = [
            'class_id' => $class_id,
            'subject_id' => $subjects[112],
            'exam_id'  => $exam->id,
            'grade_id' => 1,
            'combine_subject_id' => null,
            'marks_distribution' => json_encode([
                ['type' => 1, 'total_marks' => 50, 'pass_marks' => 25],
                ['type' => 2, 'total_marks' => 30, 'pass_marks' => 15],
                ['type' => 7, 'total_marks' => 20, 'pass_marks' => 10],
            ]),
            'passing_rule' => 3,
            'total_exam_marks' => 100,
            'over_all_pass'    => 50,
            'created_at' => $created_at,
            'created_by' => $created_by
        ];

        \App\ExamRule::insert($rules);



    }

    private function examMarksData() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $class_id = 1;
        $academic_year_id = 1;

        $subjects = \App\Subject::where('class_id', $class_id)
            ->orderBy('code', 'asc')
            ->get(['id']);

        $exam = \App\Exam::where('class_id', $class_id)->orderBy('id', 'asc')->first();

        $students = \App\Registration::where('class_id', $class_id)->where('academic_year_id', 1)
            ->get(['id', 'section_id'])
            ->reduce(function ($students, $student) {
                $students[$student->id] = $student->section_id;
                return $students;
            });


        $marksData = [];

        foreach ($subjects as $subject){
            $examRule = \App\ExamRule::where('exam_id',$exam->id)
                ->where('subject_id', $subject->id)
                ->first();

            //pull grading information
            $grade = \App\Grade::where('id', $examRule->grade_id)->first();

            $gradingRules = json_decode($grade->rules);

            //exam distributed marks rules
            $distributeMarksRules = [];
            foreach (json_decode($examRule->marks_distribution) as $rule){
                $distributeMarksRules[$rule->type] = [
                    'total_marks' => $rule->total_marks,
                    'pass_marks' => $rule->pass_marks
                ];
            }

            //loop through students
            foreach ($students as $student_id => $section_id){
                $marks = $this->generateMarks($distributeMarksRules);
                [$isInvalid, $message, $totalMarks, $grade, $point] = AppHelper::processMarksAndCalculateResult($examRule,
                    $gradingRules, $distributeMarksRules, $marks);


                $marksData[] = [
                    'academic_year_id' => 1,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'registration_id' => $student_id,
                    'exam_id' => $exam->id,
                    'subject_id' => $subject->id,
                    'marks' => json_encode($marks),
                    'total_marks' => $totalMarks,
                    'grade' => $grade,
                    'point' => $point,
                    'present' => '1',
                    "created_at" => $created_at,
                    "created_by" => $created_by,
                ];


            }
        }

        \App\Mark::insert($marksData);



    }

    private function generateMarks($distributeMarksRules){
        $marks = [];
        foreach ($distributeMarksRules as $type => $values){
            $marks[$type] = rand(0, $values['total_marks']);
        }

        return $marks;

    }

    private function generateResult() {
        $created_by = 1;
        $created_at = Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'));

        $class_id = 1;
        $acYear = 1;
        $examInfo = \App\Exam::where('class_id', $class_id)->orderBy('id', 'asc')->first();

        // pull default grading system
        $grade_id = 1;
        $grade = \App\Grade::where('id', $grade_id)->first();

        // pull exam rules subject wise and find combine subject
        $examRules = \App\ExamRule::where('class_id', $class_id)
            ->where('exam_id', $examInfo->id)
            ->select('subject_id','combine_subject_id','passing_rule','marks_distribution','total_exam_marks','over_all_pass')
            ->with(['subject' => function($query){
                $query->select('id','type');
            }])
            ->get()
            ->reduce(function ($examRules, $rule){
                $examRules[$rule->subject_id] =[
                    'combine_subject_id' => $rule->combine_subject_id,
                    'passing_rule' => $rule->passing_rule,
                    'marks_distribution' => json_decode($rule->marks_distribution),
                    'total_exam_marks' => $rule->total_exam_marks,
                    'over_all_pass' => $rule->over_all_pass,
                    'subject_type' => $rule->subject->getOriginal('type')
                ];
                return $examRules;
            });


        //pull students with marks
        $exam_id = $examInfo->id;
        $students = \App\Registration::where('status', AppHelper::ACTIVE)
            ->where('academic_year_id', $acYear)
            ->where('class_id', $class_id)
            ->select('id')
            ->with(['marks' => function($query) use($acYear,$class_id,$exam_id){
                $query->select('registration_id','subject_id','marks', 'total_marks', 'point', 'present')
                    ->where('academic_year_id', $acYear)
                    ->where('class_id', $class_id)
                    ->where('exam_id', $exam_id);
            }])
            ->get();

        $resultInsertData = [];
        $combineResultInsertData = [];
        $gradingRules = json_decode($grade->rules);
        $userId = $created_by;

        //loop  the students
        foreach ($students as $student){
            $totalMarks = 0;
            $totalPoint = 0;
            $totalSubject = 0;
            $combineSubjectsMarks = [];
            $isFail = false;
            $subjectFailCount = 0;

            $studentSubjects = $student->subjects->reduce(function ($studentSubjects, $subject){
                $studentSubjects[$subject->id] =  $subject->pivot->subject_type;
                return $studentSubjects;
            });

            foreach ($student->marks as $marks) {
                //find combine subjects
                $isAndInCombineSubject = AppHelper::isAndInCombine($marks->subject_id, $examRules);
                if ($isAndInCombineSubject) {
                    $combineSubjectsMarks[$marks->subject_id] = $marks;

                    //skip for next subject
                    continue;
                }

                //find 4th subject AppHelper::SUBJECT_TYPE
                $is4thSubject = ($studentSubjects[$marks->subject_id] == 2) ? 1 : 0;
                if ($is4thSubject) {

                    if ($marks->point >= $examInfo->elective_subject_point_addition) {
                        $totalPoint += ($marks->point - $examInfo->elective_subject_point_addition);
                    }

                    $totalMarks += $marks->total_marks;

                    //skip for next subject
                    continue;
                }

                //process not combine and 4th subjects
                if (!$isAndInCombineSubject && !$is4thSubject) {

                    $totalMarks += $marks->total_marks;
                    $totalPoint += $marks->point;
                    $totalSubject++;
                    if (intval($marks->point) == 0) {
                        $isFail = true;
                        $subjectFailCount++;
                    }

                }
            }


            //now process combine subjects
            foreach ($examRules as $subject_id => $data) {
                if ($data['combine_subject_id'] != null) {
                    $totalSubject++;
                    $subjectMarks = $combineSubjectsMarks[$subject_id];
                    $pairSubjectMarks = $combineSubjectsMarks[$data['combine_subject_id']];

                    [$pairFail, $combineTotalMarks, $pairTotalMarks] = AppHelper::processCombineSubjectMarks($subjectMarks, $pairSubjectMarks, $data, $examRules[$data['combine_subject_id']]);

                    $totalMarks += $pairTotalMarks;

                    if ($pairFail) {
                        //AppHelper::GRADE_TYPES
                        $pairGrade = "F";
                        $pairPoint = 0.00;
                        $isFail = true;
                        $subjectFailCount++;
                    } else {

                        [$pairGrade, $pairPoint] = AppHelper::findGradePointFromMarks($gradingRules, $pairTotalMarks);
                        $totalPoint += $pairPoint;
                    }

                    //need to store in db for marks sheet print
                    $combineResultInsertData[] = [
                        'registration_id' => $student->id,
                        'subject_id' => $subject_id,
                        'exam_id' => $examInfo->id,
                        'total_marks' => $combineTotalMarks,
                        'grade' => $pairGrade,
                        'point' => $pairPoint,
                    ];

                }
            }


            $finalPoint = ($totalPoint / $totalSubject);
            if ($isFail) {
                //AppHelper::GRADE_TYPES
                $finalGrade = 'F';
            } else {
                $finalGrade = AppHelper::findGradeFromPoint($finalPoint, $gradingRules);
            }

            $resultInsertData[] = [
                'academic_year_id' => $acYear,
                'class_id' => $class_id,
                'registration_id' => $student->id,
                'exam_id' => $examInfo->id,
                'total_marks' => $totalMarks,
                'grade' => $finalGrade,
                'point' => $finalPoint,
                'subject_fail_count' => $subjectFailCount,
                "created_at" => $created_at,
                "created_by" => $userId,
            ];

        }

        \App\Result::insert($resultInsertData);
        \Illuminate\Support\Facades\DB::table('result_publish')->insert([
            'academic_year_id' => $acYear,
            'class_id' => $class_id,
            'exam_id' => $exam_id,
            'publish_date' => $created_at->format('Y-m-d')
        ]);
        \Illuminate\Support\Facades\DB::table('result_combines')->insert($combineResultInsertData);


    }

}
