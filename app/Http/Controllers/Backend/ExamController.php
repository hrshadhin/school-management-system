<?php

namespace App\Http\Controllers\Backend;

use App\Exam;
use App\ExamRule;
use App\Grade;
use Illuminate\Http\Request;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::get();
        return view('backend.exam.list', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exam = null;
        $marksDistributionTypes = [1,2,6];

        return view('backend.exam.add', compact('exam', 'marksDistributionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request, [
                'name' => 'required|max:255',
                'elective_subject_point_addition' => 'required|numeric',
                'marks_distribution_types' => 'required|array',
            ]
        );


        $data = $request->all();
        $data['marks_distribution_types'] = json_encode($data['marks_distribution_types']);

        // now save employee
        Exam::create($data);

        //now notify the admins about this record
        $msg = $data['name']." exam added by ".auth()->user()->name;
        $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
        // Notification end

        return redirect()->route('exam.create')->with('success', 'Exam added!');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        //todo: need protection to massy events. like modify after used or delete after user
        $marksDistributionTypes = json_decode($exam->marks_distribution_types,true);

        return view('backend.exam.add', compact('exam', 'marksDistributionTypes'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $exam = Exam::findOrFail($id);
        //todo: need protection to massy events. like modify after used or delete after user
        $this->validate(
            $request, [
                'name' => 'required|max:255',
                'elective_subject_point_addition' => 'required|numeric',
                'marks_distribution_types' => 'required|array',
            ]
        );


        $data = $request->all();
        $data['marks_distribution_types'] = json_encode($data['marks_distribution_types']);
        $exam->fill($data);
        $exam->save();

        return redirect()->route('exam.index')->with('success', 'Exam Updated!');
    }


    /**
     * Destroy the resource
     */
    public function destroy($id) {
        $exam = Exam::findOrFail($id);
        $exam->delete();
                //todo: need protection to massy events. like modify after used or delete after user
        return redirect()->route('exam.index')->with('success', 'Exam Deleted!');
    }

    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $exam =  Exam::findOrFail($id);
        if(!$exam){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $exam->status = (string)$request->get('status');

        $exam->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }


    /**
     * grade  manage
     * @return \Illuminate\Http\Response
     */
    public function gradeIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $grade = Grade::findOrFail($request->get('hiddenId'));
            $haveRules = ExamRule::where('grade_id', $grade->id)->count();
            if($haveRules){
                return redirect()->route('exam.grade.index')->with('error', 'Can not delete! Grade used in exam rules.');
            }

            $grade->delete();

            //now notify the admins about this record
            $msg = $grade->name." grade deleted by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('exam.grade.index')->with('success', 'Record deleted!');
        }

        //for get request
        $grades = Grade::get();
        return view('backend.exam.grade.list', compact('grades'));
    }

    /**
     * grade create, read, update manage
     * @return \Illuminate\Http\Response
     */
    public function gradeCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {

            //protection to prevent massy event. Like edit grade after its use in rules
            // or marks entry
            if($id){
                $grade = Grade::find($id);
                //if grade use then can't edit it
                if($grade) {
                    $haveRules = ExamRule::where('grade_id', $grade->id)->count();
                    if ($haveRules) {
                        return redirect()->route('exam.grade.index')->with('error', 'Can not Edit! Grade used in exam rules.');
                    }
                }
            }

            $this->validate($request, [
                'name' => 'required|max:255',
                'grade' => 'required|array',
                'marks_from' => 'required|array',
                'marks_upto' => 'required|array',
            ]);

            $rules = [];
            $inputs = $request->all();
            foreach ($inputs['grade'] as $key => $value){
                $rules[] = [
                    'grade' => $value,
                    'marks_from' => $inputs['marks_from'][$key],
                    'marks_upto' => $inputs['marks_upto'][$key]
                ];
            }

            $data = [
                'name' => $request->get('name'),
                'rules' => json_encode($rules)
            ];

            Grade::updateOrCreate(
                ['id' => $id],
                $data
            );

            if(!$id){
                //now notify the admins about this record
                $msg = $data['name']." graded added by ".auth()->user()->name;
                $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
                // Notification end
            }


            $msg = "Grade ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('exam.grade.index')->with('success', $msg);
        }

        //for get request
        $grade = Grade::find($id);

        //if grade use then can't edit it
        if($grade) {
            $haveRules = ExamRule::where('grade_id', $grade->id)->count();
            if ($haveRules) {
                return redirect()->route('exam.grade.index')->with('error', 'Can not Edit! Grade used in exam rules.');
            }
        }

        return view('backend.exam.grade.add', compact('grade'));
    }

}
