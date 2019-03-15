<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Academic Calendar @endsection
<!-- End block -->


<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Academic Calendar
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Academic Calendar</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header border">
                        <div class="col-md-2">
                        <div class="form-group has-feedback">
                            <input type='text' class="form-control only_year_picker"  readonly name="year" placeholder="year" value="{{$year}}"  minlength="4" maxlength="4" />
                        </div>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('settings.academic_calendar.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="listDataTable" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                                <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="{{'30%'}}">Title</th>
                                    <th width="12%">Date From</th>
                                    <th width="12%">Date Upto</th>
                                    <th width="5%">Holiday</th>
                                    <th width="5%">Exam</th>
                                    <th width="16%"> Description</th>
                                    <th class="notexport" width="15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($calendars as $calendar)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>{{ $calendar->title }}</td>
                                        <td>{{ $calendar->date_from->format('d/m/Y') }}</td>
                                        <td>{{ $calendar->date_upto->format('d/m/Y') }}</td>
                                        <td>
                                            @if($calendar->is_holiday == 1)
                                                <span class="badge bg-3">Yes</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($calendar->is_exam == 1)
                                                <span class="badge bg-3">Yes</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$calendar->description}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a title="Edit" href="{{URL::route('settings.academic_calendar.edit',$calendar->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                </a>
                                            </div>
                                            <!-- todo: have problem in mobile device -->
                                            <div class="btn-group">
                                                <form  class="myAction" method="POST" action="{{URL::route('settings.academic_calendar.destroy')}}">
                                                    @csrf
                                                    <input type="hidden" name="hiddenId" value="{{$calendar->id}}">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
                                    <th width="{{'30%'}}">Title</th>
                                    <th width="12%">Date From</th>
                                    <th width="12%">Date Upto</th>
                                    <th width="5%">Holiday</th>
                                    <th width="5%">Exam</th>
                                    <th width="16%"> Description</th>
                                    <th class="notexport" width="15%">Action</th>
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
        $(document).ready(function () {
            Generic.initCommonPageJS();
            Generic.initDeleteDialog();
            $('input[name="year"]').on('dp.change', function (event) {
                if($(this).val()) {
                    let getUrl = window.location.href.split('?')[0] + '?year='+$(this).val();
                     window.location = getUrl;
                }

            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
