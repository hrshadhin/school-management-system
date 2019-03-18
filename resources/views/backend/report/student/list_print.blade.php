@extends('backend.report.layouts.master', ['headerData' => $headerData,'printIt' => 1])
@section('extraStyle')
    <style>
        @page {
            size:  A4 landscape;
        }
    </style>
@endsection
@section('reportBody')
    <div class="report-body">
        <div class="report-filter">
            <span class="filter-text">Filters:</span> <span class="filters">{{implode(' || ',$filters)}}</span>
        </div>
        <div class="report-data">
            <div class="row">
                <div class="col-xs-12">
                    <table class="main-data">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            @if($showClass) <th>Class</th> @endif
                            @if($showSection) <th>Section</th> @endif
                            <th>Regi No.</th>
                            <th>Roll</th>
                            <th width="15%">Father Details</th>
                            <th width="15%">Mother Details</th>
                            <th width="10%">Guardian Details</th>
                            <th width="15%">Present Address</th>
                            <th width="15%">Permanent Address</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$student->info->name}}</td>
                                    @if($showClass) <td>{{$student->class->name}}</td> @endif
                                    @if($showSection) <td>{{$student->section->name}}</td> @endif
                                    <td>{{$student->regi_no}}</td>
                                    <td>{{$student->roll_no}}</td>
                                    <td>{{$student->info->father_name}} {{$student->info->father_phone_no}}</td>
                                    <td>{{$student->info->mother_name}} {{$student->info->mother_phone_no}}</td>
                                    <td>{{$student->info->guardian}} {{$student->info->guardian_phone_no}}</td>
                                    <td>{{$student->info->present_address}}</td>
                                    <td>{{$student->info->permanent_address}}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="report-authority">
            <div class="row">
                <div class="col-xs-4">
                    <h5>Printed By: {{auth()->user()->name}}</h5>
                </div>
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                </div>
            </div>
        </div>
    </div>
@endsection