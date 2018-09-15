<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\AppHelper;
use App\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AcademicYear;

class AdministratorController extends Controller
{
    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearIndex(Request $request)
    {
        //for save on POST request
        if ($request->isMethod('post')) {//
            $this->validate($request, [
                'hiddenId' => 'required|integer',
            ]);
            $year = AcademicYear::findOrFail($request->get('hiddenId'));

            // now check is academic year set or not
            $settings = AppHelper::getAppSettings();
            $haveStudent = Registration::where('academic_year_id', $year->id)->count();
            if((isset($settings['academic_year']) && (int)$settings['academic_year'] == $year->id) || ($haveStudent > 0)){
                return redirect()->route('administrator.academic_year')->with('error', 'Can not delete it because this year have student or have in default setting.');
            }
            $year->delete();

            return redirect()->route('administrator.academic_year')->with('success', 'Record deleted!');
        }

        //for get request
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();


        return view('backend.administrator.academic.list', compact('academicYears'));
    }

    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearCru(Request $request, $id=0)
    {
        //for save on POST request
        if ($request->isMethod('post')) {
            ;
            $this->validate($request, [
                'title' => 'required|min:4|max:255',
                'start_date' => 'required|min:10|max:255',
                'end_date' => 'required|min:10|max:255',
            ]);

            $data = $request->all();
            $datetime = Carbon::createFromFormat('d/m/Y',$data['start_date']);
            $data['start_date'] = $datetime;
            $datetime = Carbon::createFromFormat('d/m/Y',$data['end_date']);
            $data['end_date'] = $datetime;
            if(!$id){
                $data['status'] = '1';
            }

            AcademicYear::updateOrCreate(
                ['id' => $id],
                $data
            );
            $msg = "Academic year ";
            $msg .= $id ? 'updated.' : 'added.';

            return redirect()->route('administrator.academic_year')->with('success', $msg);
        }

        //for get request
        $academicYear = AcademicYear::find($id);

        return view('backend.administrator.academic.add', compact('academicYear'));
    }

    /**
     * academic year  manage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function academicYearChangeStatus(Request $request, $id=0)
    {
        $year =  AcademicYear::findOrFail($id);
        if(!$year){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $settings = AppHelper::getAppSettings();
        if(isset($settings['academic_year']) && (int)$settings['academic_year'] == $year->id){
            return [
                'success' => false,
                'message' => 'Can not change status! Year is using as academic year right now.'
            ];
        }

        $year->status = (string)$request->get('status');

        $year->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }
}
