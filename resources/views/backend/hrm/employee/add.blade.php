<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Employee @endsection
<!-- End block -->



<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Employee
            <small>@if($employee) Update @else Add New @endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('hrm.employee.index')}}"><i class="fa icon-teacher"></i> Employee</a></li>
            <li class="active">@if($employee) Update @else Add @endif</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form novalidate id="entryForm" action="@if($employee) {{URL::Route('hrm.employee.update', $employee->id)}} @else {{URL::Route('hrm.employee.store')}} @endif" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            @csrf
                            @if($employee)  {{ method_field('PATCH') }} @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" name="name" placeholder="name" value="@if($employee){{ $employee->name }}@else{{old('name')}}@endif" required minlength="2" maxlength="255">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="designation">Designation<span class="text-danger">*</span></label>
                                        {!! Form::select('designation', AppHelper::EMPLOYEE_DESIGNATION_TYPES, $designation , ['placeholder' => 'Pick a designation', 'class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('designation') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="qualification">Qualification</label>
                                        <input type="text" class="form-control" name="qualification" placeholder="MA,BA,B. Sc" value="@if($employee){{ $employee->qualification }}@else{{old('qualification')}}@endif"  maxlength="255">
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('qualification') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="dob">Date of birth<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control date_picker2"  readonly name="dob" placeholder="date" value="@if($employee){{ $employee->dob }}@else{{old('dob')}}@endif" required minlength="10" maxlength="255" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('dob') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="gender">Gender<span class="text-danger">*</span>
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select gender type"></i>
                                        </label>
                                        {!! Form::select('gender', AppHelper::GENDER, $gender , ['class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="religion">Religion<span class="text-danger">*</span>
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select religion type"></i>
                                        </label>
                                        {!! Form::select('religion', AppHelper::RELIGION, $religion , ['class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('religion') }}</span>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="email">Email<span class="text-black">*</span>
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Only required when create user."></i>

                                        </label>
                                        <input  type="email" class="form-control" name="email"  placeholder="email address" value="@if($employee){{$employee->email}}@else{{old('email')}}@endif" maxlength="100">
                                        <span class="fa fa-envelope form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="phone_no">Phone/Mobile No.<span class="text-danger">*</span></label>
                                        <input  type="text" class="form-control" name="phone_no" required placeholder="phone or mobile number" value="@if($employee){{$employee->phone_no}}@else{{old('phone_no')}}@endif" min="8" maxlength="15">
                                        <span class="fa fa-phone form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="id_card">ID Card No. / Employee ID<span class="text-danger">*</span></label>
                                        <input  type="text" class="form-control" name="id_card"  placeholder="id card number" value="@if($employee){{$employee->id_card}}@else{{old('id_card')}}@endif" required minlength="4" maxlength="50">
                                        <span class="fa fa-id-card form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('id_card') }}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="role_id">Employee Type/Role<span class="text-danger">*</span>
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Set a employee Type"></i>
                                        </label>
                                        {!! Form::select('role_id', $roles, $role , ['placeholder' => 'Pick a type...','class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="joining_date">Joining Date<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control date_picker2"  readonly name="joining_date" placeholder="date" value="@if($employee){{$employee->joining_date->format('d/m/Y')}}@else{{ old('joining_date') }}@endif" required minlength="10" maxlength="255" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('joining_date') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="shift">Shift<span class="text-danger">*</span>
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="select shift"></i>
                                        </label>
                                        {!! Form::select('shift', AppHelper::EMP_SHIFTS, $shift , ['class' => 'form-control select2', 'required' => 'true']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('shift') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="duty_start">Duty Start</label>
                                        <input type='text' class="form-control time_picker"  readonly name="duty_start" placeholder="time" value="@if($employee && $employee->duty_start){{$employee->duty_start->format('h:i a')}}@else{{ old('duty_start') }}@endif" maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('duty_start') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="duty_end">Duty End</label>
                                        <input type='text' class="form-control time_picker"  readonly name="duty_end" placeholder="time" value="@if($employee && $employee->duty_end){{$employee->duty_end->format('h:i a')}}@else{{ old('duty_end') }}@endif" maxlength="8" />
                                        <span class="fa fa-clock-o form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('duty_end') }}</span>
                                    </div>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="address">Address</label>
                                        <textarea name="address" class="form-control"  maxlength="500" >@if($employee){{ $employee->address }}@else{{ old('address') }} @endif</textarea>
                                        <span class="fa fa-location-arrow form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="photo">Photo<br><span class="text-black">[min 150 X 150 size and max 200kb]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="photo" placeholder="Photo image">
                                        @if($employee && isset($employee->photo))
                                            <input type="hidden" name="oldPhoto" value="{{$employee->photo}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback" style="top:45px;"></span>
                                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="photo">Signature<br><span class="text-black">[max 170 X 60 size and max 100kb]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="signature" placeholder="Signature image">
                                        @if($employee && isset($employee->signature))
                                            <input type="hidden" name="oldSignature" value="{{$employee->signature}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback" style="top:45px;"></span>
                                        <span class="text-danger">{{ $errors->first('signature') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group has-feedback">
                                        <label for="order">Order sequence<span class="text-danger">*</span>
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Position/sorting/ordering number"></i>
                                        </label>
                                        <input  type="number" class="form-control" name="order" placeholder="1,2,3,5"  value="@if($employee){{ $employee->order }}@else{{ old('order') }}@endif" min="0" required>
                                        <span class="fa fa-sort-numeric-asc form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
                                    </div>
                                </div>
                                @if($employee)
                                    <div class="col-md-2">
                                        <div class="form-group has-feedback">
                                            <label for="leave_date">Leave Date</label>
                                            <input type='text' class="form-control date_picker_with_clear"  readonly name="leave_date" placeholder="date" value="@if($employee && $employee->leave_date){{$employee->leave_date->format('d/m/Y')}}@else{{ old('leave_date') }}@endif"  minlength="10" maxlength="255" />
                                            <span class="fa fa-calendar form-control-feedback"></span>
                                            <span class="text-danger">{{ $errors->first('leave_date') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <hr>
                            <div class="row">
                                @if(!$employee)
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="username">Username</label>
                                        <input  type="text" class="form-control" value="" name="username" placeholder="leave blank if not need to create user" minlength="5" maxlength="255">
                                        <span class="glyphicon glyphicon-info-sign form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="password">Passwrod</label>
                                        <input type="password" class="form-control" name="password" placeholder="leave blank if not need to create user" minlength="6" maxlength="50">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($employee && !$employee->user_id)
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="user_id">User
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Leave as it is, if not need user"></i>
                                        </label>
                                        {!! Form::select('user_id', $users, null , ['placeholder' => 'Pick if needed','class' => 'form-control select2']) !!}
                                        <span class="form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                    </div>
                                </div>

                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('hrm.employee.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa @if($employee) fa-refresh @else fa-plus-circle @endif"></i> @if($employee) Update @else Add @endif</button>

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
           HRM.employeeInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
