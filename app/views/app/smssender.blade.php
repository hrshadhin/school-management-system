@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-envelope"></i> Bulk SMS Send</h2>

                </div>
                <div class="box-content">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <form role="form" action="/sms/send" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="row">
                              <div class="col-md-12">

                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label class="control-label" for="class">Class</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                              {{ Form::select('class',$classes,$formdata->class,['class'=>'form-control','required'=>'true'])}}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label class="control-label" for="section">Section</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                              <?php  $data=[
                                                      'A'=>'A',
                                                      'B'=>'B',
                                                      'C'=>'C',
                                                      'D'=>'D',
                                                      'E'=>'E',
                                                      'F'=>'F',
                                                      'G'=>'G',
                                                      'H'=>'H',
                                                      'I'=>'I',
                                                      'J'=>'J'
                                              ];?>
                                              {{ Form::select('section',$data,$formdata->section,['class'=>'form-control','required'=>'true'])}}


                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label class="control-label" for="shift">Shift</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                              <?php  $data=[
                                                      'Day'=>'Day',
                                                      'Morning'=>'Morning'
                                              ];?>
                                              {{ Form::select('shift',$data,$formdata->shift,['class'=>'form-control','required'=>'true'])}}


                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group ">
                                          <label for="session">session</label>
                                          <div class="input-group">

                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                              <input type="text" id="session" required="true" class="form-control datepicker2" name="session" value="{{$formdata->session}}"   data-date-format="yyyy">
                                          </div>
                                      </div>
                                  </div>

                              </div>
                          </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sender">Sender</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <input type="text" class="form-control" required name="sender" value="supersoft">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                <textarea type="text" id="message" class="form-control" maxlength="160" required name="message" placeholder="Message 160 letters"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sender">&nbsp;</label>
                                            <div class="input-group">
                                                  <label id="typing" class="text-info">160 characters remaining<lable>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <button class="btn btn-primary btn-lg pull-right" type="submit"><i class="glyphicon glyphicon-envelope"></i> Send</button>
                            <br>
                            <br>

                        </form>

                    <br>
                </div>









            </div>
        </div>
    </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
<script>
  $( document ).ready(function() {
    $(".datepicker2").datepicker( {
        format: " yyyy", // Notice the Extra space at the beginning
        viewMode: "years",
        minViewMode: "years",
        autoclose:true

    });
    var text_max = 160;
    $('#typing').html(text_max + ' characters remaining');

    $('#message').keyup(function() {
        var text_length = $('#message').val().length;
        var text_remaining = text_max - text_length;
         if(text_remaining>0)
         {
           $('#typing').removeClass();
           $('#typing').addClass('text-info');
         }
         else{
           $('#typing').removeClass();
            $('#typing').addClass('text-danger');
         }
        $('#typing').html(text_remaining + ' characters remaining');
    });
});
</script>

@stop
