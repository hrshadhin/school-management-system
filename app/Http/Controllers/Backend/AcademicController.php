<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelper;
use App\Registration;
use App\Section;
use App\Subject;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\IClass;
use App\Employee;
use Illuminate\Support\Facades\Cache;

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
        $iclasses = IClass::select('id','name','numeric_value','order','status','note','group')->orderBy('order', 'asc')->get();

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
            ;
            $this->validate($request, [
                'name' => 'required|min:2|max:255',
                'numeric_value' => 'required|integer',
                'order' => 'required|integer',
                'group' => 'nullable|max:20',
                'note' => 'max:500',
            ]);

            $data = $request->all();
            if(!$id){
                $data['status'] = AppHelper::ACTIVE;

            }
            else{
                unset($data['numeric_value']);
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

        if($iclass){
            $group = $iclass->group;
        }

        return view('backend.academic.iclass.add', compact('iclass','group'));
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
            ->pluck('name', 'id');
        $teacher = null;

        $classes = IClass::where('status', AppHelper::ACTIVE)
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
            $teacherId = 0;
            if(session('user_role_id',0) == AppHelper::USER_TEACHER){
                $teacherId = auth()->user()->teacher->id;
            }
            $subjects = Subject::select('id', 'name as text')
                ->where('class_id',$class_id)
                ->sType($subjectType)
                ->when($teacherId, function ($query) use($teacherId){
                    $query->where('teacher_id', $teacherId);
                })
                ->where('status', AppHelper::ACTIVE)
                ->orderBy('name', 'asc')
                ->get();
            return $subjects;
        }


        $class_id = $request->query->get('class',0);
        $subjects = Subject::iclass($class_id)->with('teacher')->with('class')->orderBy('name', 'asc')->get();
        $classes = IClass::where('status', AppHelper::ACTIVE)
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
            ;
            $this->validate($request, [
                'name' => 'required|min:1|max:255',
                'code' => 'required|min:1|max:255',
                'type' => 'required|numeric',
                'class_id' => 'required|integer',
                'teacher_id' => 'required|integer',
            ]);

            $data = $request->all();

            Subject::updateOrCreate(
                ['id' => $id],
                $data
            );


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
        $subject = Subject::find($id);

        $teachers = Employee::where('role_id', AppHelper::EMP_TEACHER)
            ->where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');
        $teacher = null;

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');
        $iclass = null;
        $subjectType = null;

        if($subject){
            $teacher = $subject->teacher_id;
            $iclass = $subject->class_id;
            $subjectType = $subject->getOriginal('type');
        }

        return view('backend.academic.subject.add', compact('subject', 'iclass', 'classes', 'teachers', 'teacher', 'subjectType'));
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
