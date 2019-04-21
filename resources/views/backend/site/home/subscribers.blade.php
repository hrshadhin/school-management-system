<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Subscribers @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Subscribers
            <small>Subscriber List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Subscribers</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">All Subscribers</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="Subscribers" class="table table-bordered table-striped list_view_table">
                            <thead>
                            <tr>
                                <th width="60%">Email</th>
                                <th width="40%">Subscribe At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscribers as $sub)
                                <tr>
                                    <td>{{ $sub->meta_value }}</td>
                                    <td> {{ $sub->created_at->format('j M, Y h:m:s a') }}</td>

                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="60%">Email</th>
                                <th width="40%">Subscribe At</th>
                            </tr>
                            </tfoot>
                        </table>
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
            $('#Subscribers').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
