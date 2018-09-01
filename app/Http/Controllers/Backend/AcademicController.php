<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\IClass;
use App\Employee;

class AcademicController extends Controller
{
    /**
     * class  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $iclass = IClass::findOrFail($request->get('hiddenId'));
            $iclass->delete();

            return redirect()->route('academic.class')->with('success', 'Record deleted!');
        }

        //for get request
        $iclasses = IClass::with('teacher')->orderBy('numeric_value', 'asc')->get();


        return view('backend.academic.iclass.list', compact('iclasses'));
    }

    /**
     * class create, read, update manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            ;
            $this->validate($request, [
                'name' => 'required|min:2|max:255',
                'numeric_value' => 'required|numeric',
                'teacher_id' => 'required|numeric',
                'note' => 'max:500',
            ]);

            $data = $request->all();
            if(!$id){
                $data['status'] = AppHelper::ACTIVE;
            }

            IClass::updateOrCreate(
                ['id' => $id],
                $data
            );
            $msg = "Class ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('academic.class')->with('success', $msg);
        }

        //for get request
        $iclass = IClass::find($id);

        $teachers = Employee::where('emp_type', AppHelper::EMP_TEACHER)
            ->where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');
        $teacher = null;

        if($iclass){
            $teacher = $iclass->teacher_id;
        }

        return view('backend.academic.iclass.add', compact('iclass', 'teachers', 'teacher'));
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

}
