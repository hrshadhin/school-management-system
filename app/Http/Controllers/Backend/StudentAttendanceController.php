<?php

namespace App\Http\Controllers\Backend;

use App\AcademicYear;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Section;
use App\StudentAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get query parameter for filter the fetch
        $class_id = $request->query->get('class',0);
        $section_id = $request->query->get('section',0);
        $acYear = $request->query->get('academic_year',0);
        $attendance_date = $request->query->get('attendance_date','');

        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->pluck('name', 'id');
        $sections = [];

        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }
        else{

            $acYear = $request->query->get('academic_year',AppHelper::getAcademicYear());
        }


        //now fetch attendance data
        $attendances = [];
        if($class_id && $section_id && $acYear && $attendance_date) {



            $sections = Section::where('status', AppHelper::ACTIVE)
                ->where('class_id', $class_id)
                ->pluck('name', 'id');
        }


        return view('backend.attendance.student.list', compact(
            'academic_years',
            'classes',
            'sections',
            'acYear',
            'class_id',
            'section_id',
            'attendance_date',
            'attendances'
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
            ->pluck('name', 'id');
        //if its college then have to get those academic years
        $academic_years = [];
        if(AppHelper::getInstituteCategory() == 'college') {
            $academic_years = AcademicYear::where('status', '1')->orderBy('id', 'desc')->pluck('title', 'id');
        }

        return view('backend.attendance.student.add', compact(
            'academic_years',
            'classes'
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
        //
    }


    /**
     * status change
     * @return mixed
     */
    public function changeStatus(Request $request, $id=0)
    {

        $attendance =  StudentAttendance::findOrFail($id);
        if(!$attendance){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $attendance->present = (string)$request->get('status');

        $attendance->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }

    /**
     * Upload file for add attendance
     * @return mixed
     */
    public function createFromFile(Request $request)
    {

       dd('file upload');
    }
}
