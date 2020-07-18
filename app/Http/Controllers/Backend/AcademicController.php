<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelper;
use App\Registration;
use App\Section;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use App\IClass;
use App\Employee;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AcademicController extends Controller
{
    /**
     * class  manage
     * @return \Illuminate\Http\Response
     */
    public function classIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $iclass = IClass::findOrFail($request->get('hiddenId'));

            $haveSection = Section::where('class_id', $iclass->id)->count();
            $haveStudent = Registration::where('class_id', $iclass->id)->count();
            if($haveStudent || $haveSection){
                return redirect()->route('academic.class')->with('error', 'Can not delete! Class used in section or have student.');
            }

            $iclass->delete();

            //now notify the admins about this record
            $msg = $iclass->name." class deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            //invalid cache
            Cache::forget('selected_classes_4_dashboard');

            return redirect()->route('academic.class')->with('success', 'Record deleted!');
        }

        //for get request
        $iclasses = IClass::orderBy('order', 'asc')->get();

        return view('backend.academic.iclass.list', compact('iclasses'));
    }

    /**
     * class create, read, update manage
     * @return \Illuminate\Http\Response
     */
    public function classCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|min:2|max:255',
                'numeric_value' => 'required|integer',
                'order' => 'required|integer',
                'group' => 'nullable|max:20',
                'note' => 'max:500',
                'duration' => 'integer',
                'max_selective_subject' => 'nullable|integer'
            ]);

            $data = $request->all();
            if(!$id){
                $data['status'] = AppHelper::ACTIVE;

            }
            else{
                unset($data['numeric_value']);
            }
            if($request->has('have_selective_subject')){
                $data['have_selective_subject'] = true;
            }
            else{
                $data['have_selective_subject'] = false;
            }
            if($request->has('have_elective_subject')){
                $data['have_elective_subject'] = true;
            }
            else{
                $data['have_elective_subject'] = false;
            }
            if($request->has('is_open_for_admission')){
                $data['is_open_for_admission'] = 1;
            }
            else{
                $data['is_open_for_admission'] = 0;
            }

            IClass::updateOrCreate(
                ['id' => $id],
                $data
            );

            if(!$id){
                //now notify the admins about this record
                $msg = $data['name']." class added by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end

                //invalid cache
                Cache::forget('selected_classes_4_dashboard');
            }


            $msg = "Class ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('academic.class')->with('success', $msg);
        }

        //for get request
        $iclass = IClass::find($id);
        $group = 'None';
        $have_selective_subject = 0;
        $have_elective_subject = 0;
        $is_open_for_admission = 0;

        if($iclass){
            $group = $iclass->group;
            $have_selective_subject = $iclass->have_selective_subject;
            $have_elective_subject = $iclass->have_elective_subject;
            $is_open_for_admission = $iclass->is_open_for_admission;

        }

        return view('backend.academic.iclass.add', compact('iclass','group',
            'have_elective_subject',
            'have_selective_subject',
            'is_open_for_admission'
        ));
    }

    /**
     * class status change
     * @return mixed
     */
    public function classStatus(Request $request, $id=0)
    {

        $iclass =  IClass::findOrFail($id);
        if(!$iclass){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $iclass->status = (string)$request->get('status');

        $iclass->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }


    /**
     * section  manage
     * @return \Illuminate\Http\Response
     */
    public function sectionIndex(Request $request)
    {

        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $section = Section::findOrFail($request->get('hiddenId'));

            $haveStudent = Registration::where('section_id', $section->id)->count();
            if($haveStudent){
                return redirect()->route('academic.section')->with('error', 'Can not delete! Section have student.');
            }

            $section->delete();

            //now notify the admins about this record
            $msg = $section->name." section deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('academic.section')->with('success', 'Record deleted!');
        }


        // check for ajax request here
        if($request->ajax()){
            $class_id = $request->query->get('class', 0);
            $sections = Section::select('id', 'name as text')->where('class_id',$class_id)->where('status', AppHelper::ACTIVE)->orderBy('name', 'asc')->get();
            return $sections;
        }

        $sections = Section::with('teacher')->with('class')->orderBy('name', 'asc')->get();

        return view('backend.academic.section.list', compact('sections'));
    }

    /**
     * section create, read, update manage
     * @return \Illuminate\Http\Response
     */
    public function sectionCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            ;
            $this->validate($request, [
                'name' => 'required|min:1|max:255',
                'capacity' => 'required|numeric',
                'class_id' => 'required|integer',
                'teacher_id' => 'required|integer',
                'note' => 'max:500',
            ]);

            $data = $request->all();

            Section::updateOrCreate(
                ['id' => $id],
                $data
            );


            if(!$id){
                //now notify the admins about this record
                $msg = $data['name']." section added by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end
            }

            $msg = "section ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('academic.section')->with('success', $msg);
        }

        //for get request
        $section = Section::find($id);

        $teachers = Employee::where('role_id', AppHelper::EMP_TEACHER)
            ->where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->pluck('name', 'id');
        $teacher = null;

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $iclass = null;

        if($section){
            $teacher = $section->teacher_id;
            $iclass = $section->class_id;
        }

        return view('backend.academic.section.add', compact('section', 'iclass', 'classes', 'teachers', 'teacher'));
    }

    /**
     * section status change
     * @return mixed
     */
    public function sectionStatus(Request $request, $id=0)
    {

        $section =  Section::findOrFail($id);
        if(!$section){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $section->status = (string)$request->get('status');

        $section->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }


    /**
     * subject  manage
     * @return \Illuminate\Http\Response
     */
    public function subjectIndex(Request $request)
    {

        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $subject = Subject::findOrFail($request->get('hiddenId'));

            if(session('user_role_id',0) == AppHelper::USER_STUDENT){
                abort(401);
            }

            //todo: add delete protection here
//            $haveExam = Exam::where('section_id', $subject->id)->count();
//            if($haveExam){
//                return redirect()->route('academic.section')->with('error', 'Can not delete! Section have student.');
//            }

            $subject->delete();

            //now notify the admins about this record
            $msg = $subject->name." subject deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            //invalid dashboard cache
            Cache::forget('SubjectCount');

            return redirect()->route('academic.subject')->with('success', 'Record deleted!');
        }

        // check for ajax request here
        if($request->ajax()){
            $class_id = $request->query->get('class', 0);
            $subjectType = $request->query->get('type', 0);
            if(session('user_role_id',0) == AppHelper::USER_TEACHER){
                if(!auth()->user()->teacher){
                    return response('Access denied!', 401);
                }
                $teacherId = auth()->user()->teacher->id;
                $subjects = Subject::select('subjects.id', 'subjects.name as text')
                    ->where('class_id',$class_id)
                    ->sType($subjectType)
                    ->join('teacher_subjects','teacher_subjects.subject_id','subjects.id')
                    ->where('teacher_subjects.teacher_id', $teacherId)
                    ->where('subjects.status', AppHelper::ACTIVE)
                    ->orderBy('subjects.order','asc')
                    ->get();
            }
            else {
                $subjects = Subject::select('id', 'name as text')
                    ->where('class_id', $class_id)
                    ->sType($subjectType)
                    ->where('status', AppHelper::ACTIVE)
                    ->orderBy('order', 'asc')
                    ->get();
            }
            return $subjects;
        }


        $class_id = $request->query->get('class',0);
        $subjects = Subject::iclass($class_id)->with('teachers')
            ->with(['class' => function($q){
                $q->select('id','name');
            }])
            ->orderBy('order', 'asc')
            ->get();
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $iclass = $class_id;


        return view('backend.academic.subject.list', compact('subjects','classes', 'iclass'));
    }

    /**
     * subject create, read, update manage
     * @return \Illuminate\Http\Response
     */
    public function subjectCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required|min:1|max:255',
                'code' => 'required|min:1|max:255',
                'type' => 'required|numeric',
                'class_id' => 'required|integer',
                'teacher_id' => 'required|array',
                'order' => 'required|integer',
            ]);

            DB::beginTransaction();
            try {
                $data = $request->all();

                if($request->has('exclude_in_result')){
                    $data['exclude_in_result'] = true;
                }
                else{
                    $data['exclude_in_result'] = false;
                }

                $subject = Subject::updateOrCreate(
                    ['id' => $id],
                    $data
                );
                $subject->teachers()->sync($request->get('teacher_id'));
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
                return redirect()->back()->with("error", $message);
            }


            if(!$id){
                //now notify the admins about this record
                $msg = $data['name']." subject added by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end

                //invalid dashboard cache
                Cache::forget('SubjectCount');
            }

            $msg = "subject ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('academic.subject')->with('success', $msg);
        }

        //for get request
        $subject = Subject::with('teachers')->where('id',$id)->first();

        $teachers = Employee::where('role_id', AppHelper::EMP_TEACHER)
            ->where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->pluck('name', 'id');
        $teacher_ids = [];

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order','asc')
            ->pluck('name', 'id');
        $iclass = null;
        $subjectType = null;
        $exclude_in_result = 0;

        if($subject){
            $teacher_ids = $subject->teachers->pluck('id')->toArray();
            $iclass = $subject->class_id;
            $subjectType = $subject->getOriginal('type');
            $exclude_in_result = $subject->exclude_in_result;
        }
        return view('backend.academic.subject.add', compact('subject', 'iclass', 'classes',
            'teachers', 'teacher_ids', 'subjectType', 'exclude_in_result'));

    }

    /**
     * subject status change
     * @return mixed
     */
    public function subjectStatus(Request $request, $id=0)
    {

        $subject =  Subject::findOrFail($id);
        if(!$subject){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $subject->status = (string)$request->get('status');

        $subject->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }



}
