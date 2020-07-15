<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Marks @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Marks
            <small>Update</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('marks.index')}}"><i class="fa icon-markmain"></i> Marks</a></li>
            <li class="active"> Marks Update</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if ($errors->any())
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <form novalidate id="markForm" action="{{URL::Route('marks.update', $marks->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped list_view_table display responsive no-wrap haveForm" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Roll No.</th>
                                                @php
                                                    $marksDistributions = json_decode($examRule->marks_distribution);
                                                @endphp
                                                @foreach($marksDistributions as $distribution)
                                                    @if($distribution->total_marks > 0)
                                                        <th>{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</th>
                                                    @endif
                                                @endforeach
                                                <th>Total Marks</th>
                                                <th>Absent</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span class="text-bold">{{$marks->student->info->name}} [{{$marks->student->regi_no}}]</span>
                                                </td>
                                                <td>
                                                    {{$marks->student->roll_no}}
                                                </td>
                                                @php
                                                    $achivemarks = json_decode($marks->marks, true);
                                                @endphp
                                                @foreach($marksDistributions as $distribution)
                                                    @if($distribution->total_marks > 0)
                                                    <td>
                                                        <input type="number" @if($marks->present == 0) readonly @endif class="form-control"  name="type[{{$distribution->type}}]" value="{{$achivemarks[$distribution->type]}}" required max="{{$distribution->total_marks}}" min="0">
                                                    </td>
                                                    @endif
                                                @endforeach
                                                <td>
                                                    <input type="text" readonly class="form-control totalMarks" value="{{$marks->total_marks}}">
                                                </td>
                                                <td>
                                                    <div class="checkbox icheck inline_icheck">
                                                        <input type="checkbox" @if($marks->present == 0) checked @endif name="absent">
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Update Marks</button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        window.changeExportColumnIndex = -1;
        $(document).ready(function () {
            Academic.marksInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
