<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') FAQ @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            FAQ
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">FAQ</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">FAQ <span class="text-danger"> * Marks are required feild</span></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <form  id="faqForm" action="{{URL::Route('site.faq')}}" method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="form-group has-feedback">
                                <label for="question">Question<span class="text-danger">*</span></label>
                                <input type="text" name="question" class="form-control" placeholder="type your question" value="{{old('question')}}" maxlength="255" required />
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('question') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="answer">Answer<span class="text-danger">*</span></label>
                                <textarea  name="answer" class="form-control textarea" required minlength="5" >{{ old('answer') }}</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('answer') }}</span>
                            </div>
                            <div class="form-group">
                                <a href="{{URL::route('site.dashboard')}}" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>

                            </div>
                            <hr>
                    </form>
                            <table id="faqList" class="table table-bordered table-striped list_view_table">
                                <thead>
                                <tr>
                                    <th width="30%">Question</th>
                                    <th width="60%">Answer</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($faqs as $faq)
                                    @php
                                     $qa = json_decode($faq->meta_value);
                                    @endphp
                                    <tr>

                                        <td>{{ $qa->q }}</td>
                                        <td> {!! $qa->a !!}</td>
                                        <td>
                                            <div class="btn-group">
                                                <form class="myAction" method="POST" action="{{URL::route('site.faq_delete',$faq->id)}}">
                                                    @csrf
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
                                    <th width="30%">Qustion</th>
                                    <th width="60%">Answer</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </tfoot>
                            </table>
                            {{ $faqs->links() }}

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
    <!-- editor js -->
    <script>
        //editor jQuery Patch fixing
        jQuery = $;
    </script>
    <script src="{{ asset('/js/editor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            Site.faqInit();
            initDeleteDialog();
        });
    </script>
@endsection
<!-- END PAGE JS-->

