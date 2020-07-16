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
            <span class="filter-text">Filters:</span> <span class="filters">{{implode(' II ',$filters)}}</span>
        </div>
        <div class="report-data">
            <div class="row">
                <div class="col-xs-12">
                    <table class="classic">
                        <thead>
                        <tr>
                            <th width="5%" rowspan="2">SL</th>
                            <th width="10%" rowspan="2">Name</th>
                            <th width="5%" rowspan="2">Roll</th>
                            <th width="5%" rowspan="2">Regi No.</th>
                            <th width="55%" colspan="{{count($monthDates)}}">Day of Month</th>
                            <th width="5%" rowspan="2">P</th>
                            <th width="5%" rowspan="2">L.P</th>
                            <th width="5%" rowspan="2">A</th>
                            <th width="5%" rowspan="2">T.P</th>
                        </tr>
                        <tr>
                            @foreach($monthDates as $date => $value)
                            <th @if($value['weekend']) class="weekend" @endif>{{$value['day']}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            @php
                             $dayWisePresent = [];
                             $dayWiseAbsent = [];
                             //init 0 values
                             foreach($monthDates as $date => $value){
                                $dayWisePresent[$date] = 0;
                                $dayWiseAbsent[$date] = 0;
                             }
                            @endphp
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$student->info->name}}</td>
                                    <td>{{$student->roll_no}}</td>
                                    <td>{{$student->regi_no}}</td>
                                    @php
                                        $tPresent = 0;
                                        $tlPresent = 0;
                                        $tabsent = 0;

                                    @endphp
                                    @foreach($monthDates as $date => $value)
                                        @php
                                            $status = '';
                                            $color = '';


                                                if(isset($attendanceData[$student->id][$date])) {
                                                    if($attendanceData[$student->id][$date]['present']  == 1){
                                                        $status = 'P';
                                                        $color = 'green';
                                                        $tPresent++;
                                                        if($attendanceData[$student->id][$date]['inLate'] == 1){
                                                            $tlPresent++;
                                                        }

                                                        $dayWisePresent[$date] += 1;

                                                    }
                                                    else{
                                                        if (!$value['weekend']) {
                                                            $status = 'A';
                                                            $tabsent++;
                                                            $color = 'red';

                                                            $dayWiseAbsent[$date] += 1;
                                                        }
                                                    }
                                                }


                                            if($value['weekend']){
                                                    $status .= 'W';
                                                    $color = 'weekend';
                                            }

                                        @endphp
                                        <td class="{{$color}}">{{$status}}</td>
                                    @endforeach
                                    <td>
                                        {{($tPresent-$tlPresent)}}
                                    </td>
                                    <td>
                                       {{$tlPresent}}
                                    </td>
                                    <td>
                                        {{$tabsent}}
                                    </td>
                                    <td>
                                        {{$tPresent}}
                                    </td>
                                </tr>

                            @endforeach
                            {!! ReportHelper::generateStudentMonthlyAttendanceSumTableRows($dayWisePresent,$dayWiseAbsent) !!}
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
                    <h5>Class Teacher</h5>
                </div>
                <div class="col-xs-4">
                    <h5>@if(AppHelper::getInstituteCategory() == 'college') Principal @else Headmaster @endif</h5>
                </div>
            </div>
        </div>
    </div>
@endsection