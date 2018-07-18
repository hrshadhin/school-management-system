<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Contact Us @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Contact Us
            <small>Location</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('site.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact Us</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form  id="contactUsForm" action="{{URL::Route('site.contact_us')}}" method="post" enctype="multipart/form-data">
                        <div class="box-header">
                            <h3 class="box-title">Contact Us <span class="text-danger"> * Marks are required feild</span></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            @csrf
                            <div class="form-group has-feedback">
                                <label for="address">Address<span class="text-danger">*</span></label>
                                <textarea autofocus name="address" class="form-control" required maxlength="500" required>@if($address){{ $address->meta_value }}@endif</textarea>
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="phone_no">Phone/Mobile number<span class="text-danger">*</span></label>
                                <input type="text" name="phone_no" class="form-control" placeholder="+8801554000707,+8802458" value="@if($phone){{ $phone->meta_value }}@endif" maxlength="255" required />
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="contact@cloudschoolbd.com" value="@if($email){{ $email->meta_value }}@endif" maxlength="255" required />
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="latlong">Location(latitude and longitude)<span class="text-danger">*</span></label>
                                <input type="text" name="latlong" class="form-control" placeholder="23.7340076,90.3841824" value="@if($latlong){{ $latlong->meta_value }}@endif" maxlength="255" required />
                                <span class="glyphicon glyphicon-info form-control-feedback"></span>
                                <span class="text-danger">{{ $errors->first('latlong') }}</span>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('site.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>

                        </div>
                    </form>
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
            Site.contactUs();
        });
    </script>
@endsection
<!-- END PAGE JS-->

