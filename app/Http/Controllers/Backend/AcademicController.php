<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelper;
use App\Registration;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use App\IClass;
use App\Employee;

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

            return redirect()->route('academic.class')->with('success', 'Record deleted!');
        }

        //for get request
        $iclasses = IClass::select('id','name','numeric_value','status','note')->orderBy('numeric_value', 'asc')->get();

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
                'numeric_value' => 'required|numeric',
                'group' => 'nullable|max:15',
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

        $teachers = Employee::where('emp_type', AppHelper::EMP_TEACHER)
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

}
