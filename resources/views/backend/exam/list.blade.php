<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Exam @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
           Exam
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Exam</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header border">
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::select('class_id', $classes, $iclass , ['placeholder' => 'Pick a class...','class' => 'form-control select2', 'required' => 'true', 'id' => 'class_id_filter']) !!}
                            </div>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('exam.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="table-responsive">
                            <table id="listDataTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Class</th>
                                    <th width="20%">Name</th>
                                    <th width="10%">Elective Subject Point Above Addition</th>
                                    <th width="30%">Marks Distribution Types</th>
                                    <th width="5%">Open For Marks Entry</th>
                                    <th width="10%">Status</th>
                                    <th class="notexport" width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exams as $exam)
                                    @php
                                        $marksDistributionTypes = json_decode($exam->marks_distribution_types,true);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $exam->class->name }}</td>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->elective_subject_point_addition }}</td>
                                        <td>
                                            @foreach($marksDistributionTypes as $type)
                                                <span class="badge bg-light-blue">{{AppHelper::MARKS_DISTRIBUTION_TYPES[$type]}}</span>
                                            @endforeach

                                        </td>
                                        <td>
                                                <input class="openEntryChange" type="checkbox" data-pk="{{$exam->id}}" @if($exam->open_for_marks_entry) checked @endif data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger">

                                        </td>
                                        <td>
                                            <input class="statusChange" type="checkbox" data-pk="{{$exam->id}}" @if($exam->status) checked @endif data-toggle="toggle" data-on="<i class='fa fa-check-circle'></i>" data-off="<i class='fa fa-ban'></i>" data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a title="Edit" href="{{URL::route('exam.edit',$exam->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                </a>
                                            </div>
                                            <!-- todo: have problem in mobile device -->
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('exam.destroy',$exam->id)}}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Devare">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Class</th>
                                    <th width="20%">Name</th>
                                    <th width="10%">Elective Subject Point Above Addition</th>
                                    <th width="30%">Marks Distribution Types</th>
                                    <th width="5%">Open For Marks Entry</th>
                                    <th width="10%">Status</th>
                                    <th class="notexport" width="10%">Action</th>
                                </tr>
                                </tfoot>
                            </table>
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
        window.postUrl = '{{URL::Route("exam.status", 0)}}';
        window.changeExportColumnIndex = 6;
        $(document).ready(function () {
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
            $('#class_id_filter').on('change', function () {
                var class_id = $(this).val();
                var getUrl = window.location.href.split('?')[0];
                if(class_id){
                    getUrl +="?class="+class_id;

                }
                window.location = getUrl;

            });

            //open/close toogle button
            var stopchange = false;
            $('html #listDataTable').on('change', 'input.openEntryChange', function (e) {
                var that = $(this);
                if (stopchange === false) {
                    var isActive = $(this).prop('checked') ? 1 : 0;
                    var pk = $(this).attr('data-pk');
                    var newpostUrl = postUrl.replace(/\.?0+$/, pk);
                    axios.post(newpostUrl, { 'status': isActive, 'open_entry': 1 })
                        .then((response) => {
                            if (response.data.success) {
                                toastr.success(response.data.message);
                            }
                            else {
                                var status = response.data.message;
                                if (stopchange === false) {
                                    stopchange = true;
                                    that.bootstrapToggle('toggle');
                                    stopchange = false;
                                }
                                toastr.error(status);
                            }
                        }).catch((error) => {
                        // console.log(error.response);
                        var status = error.response.statusText;
                        if (stopchange === false) {
                            stopchange = true;
                            that.bootstrapToggle('toggle');
                            stopchange = false;
                        }
                        toastr.error(status);

                    });
                }
            });

        });
    </script>
@endsection
<!-- END PAGE JS-->
