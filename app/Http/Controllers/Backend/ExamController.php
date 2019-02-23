<?php

namespace App\Http\Controllers\Backend;

use App\Exam;
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
}
