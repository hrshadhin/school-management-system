@extends('layouts.master')

@section('content')

<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-home"></i> Dormitory Student List Report <i class="glyphicon glyphicon-user"></i></h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">


                            <div class="row">
                                <div class="col-md-12">

                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label" for="dormitory">Dormitory</label>

                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                              <select id="dormitory" name="dormitory" class="form-control" required="true">
                                                <option value="">--Select Dormitory--</option>
                                                @foreach($dormitories as $dorm)
                                                    <option value="{{$dorm->id}}">{{$dorm->name}}</option>
                                                @endforeach
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label class="control-label" for="">&nbsp;</label>
                                                <div class="input-group">
                                              <button class="btn btn-primary pull-right" id="btnPrint"><i class="glyphicon glyphicon-print"></i> Print List</button>
                                            </div>
                                            </div>
                                      </div>
                                </div>
                            </div>
                            <br>

                    </div>
                </div>



        </div>
    </div>
</div>
</div>
@stop
@section('script')

    <script type="text/javascript">
        $( document ).ready(function() {

            $( "#btnPrint" ).click(function() {
                var type = $('#dormitory').val();

                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host;
                var url =baseUrl+"/dormitory/report/std/";
                if(type!="-1") {
                   url +=type;
                    var win = window.open(url, '_blank');
                    win.focus();

                }
                else
                {
                    alert('Fill up inputs feilds correclty!!!');
                }
            });

        });

    </script>
@stop
