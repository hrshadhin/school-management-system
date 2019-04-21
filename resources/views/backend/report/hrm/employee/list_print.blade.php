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
        <div class="report-data">
            <div class="row">
                <div class="col-xs-12">
                    <table class="main-data">
                        <thead>
                        <tr>
                            <th width="4%">SL</th>
                            <th>Name</th>
                            <th width="5%">Type</th>
                            <th width="8%">Designation</th>
                            <th width="8%">Qualification</th>
                            <th width="5%">Gender</th>
                            <th width="15%">Email</th>
                            <th width="8%">Phone No.</th>
                            <th width="15%">Address</th>
                            <th width="5%">Shift</th>
                            <th width="5%">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->role->name}}</td>
                                    <td>{{$employee->designation}}</td>
                                    <td>{{$employee->qualification}}</td>
                                    <td>{{$employee->gender}}</td>
                                    <td>{{$employee->email}}</td>
                                    <td>{{$employee->phone_no}}</td>
                                    <td>{{$employee->address}}</td>
                                    <td>{{$employee->shift}}</td>
                                    <td>@if($employee->status) Active @else Deactive @endif</td>
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