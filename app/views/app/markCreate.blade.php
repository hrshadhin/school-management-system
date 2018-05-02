@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/mark/list">View List</a><br>

        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Faild.</strong> {{ Session::get('error')}}<br>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Marks Entry</h2>

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
                    <form role="form" action="/mark/create" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="class">Class</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                        <select id="class" name="class" class="form-control" >
                                                            <option value="">--Select Class--</option>

                                                            @foreach($classes as $class)
                                                                <option value="{{$class->code}}">{{$class->name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="section">Section</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <select id="section" name="section"  class="form-control" >
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                            <option value="E">E</option>
                                                            <option value="F">F</option>
                                                            <option value="G">G</option>
                                                            <option value="H">H</option>
                                                            <option value="I">I</option>
                                                            <option value="J">J</option>

                                                        </select>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label" for="shift">Shift</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <select id="shift" name="shift"  class="form-control" >
                                                            <option value="Day">Day</option>
                                                            <option value="Morning">Morning</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label for="session">session</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                        <input type="text" id="session" required="true" class="form-control datepicker2" name="session"   data-date-format="yyyy">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label" for="subject">subject</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-book blue"></i></span>
                                                        <select id="subject" name="subject" class="form-control" required="true">
                                                            <option value="">--Select Subject--</option>


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label" for="exam">Examination</label>

                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                        <select name="exam" required="true" class="form-control" >
                                                            <option value="">-Slect Exam-</option>
                                                            <option value="Class Test">Class Test</option>
                                                            <option value="Model Test">Model Test</option>
                                                            <option value="First Term">First Term</option>
                                                            <option value="Mid Term">Mid Term</option>
                                                            <option value="Final Exam">Final Exam</option>

                                                        </select>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-2">
                                            <label>Marks</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Written</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label>MCQ</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Practical</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label>SBA</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Full Marks</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="tfull">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="wfull">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="mfull">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="pfull">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="cfull">0</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Pass Marks</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="tpass">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="wpass">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="mpass">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="ppass">0</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label id="cpass">0</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="studentList" class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>

                                            <th>Registration No</th>
                                            <th>Roll No</th>
                                            <th>Name</th>
                                            <th>Written</th>
                                            <th>MCQ</th>
                                            <th>Practical</th>
                                            <th>SBA</th>
                                            <th>Absent</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        <tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="row alertZone" style="display: none;">

                        </div>
                        <!--button save -->
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary pull-right" id="btnsave" type="submit"><i class="glyphicon glyphicon-plus"></i>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">

        $( document ).ready(function() {
            $('#btnsave').hide();
            $('form').on('submit', function(event) {
                // prevent default submit action
                var that = this;
                event.preventDefault();
                // test if form is valid
                var error=0;
                var maxWritten=0;
                var writtenError=0;
                var maxMcq=0;
                var mcqError=0;
                var maxPractical=0;
                var practicalError=0;
                var maxSba=0;
                var sbaError=0;

                $('[name="written[]"').each(function () {
                    var maxValue = $(this).attr('max');
                    maxWritten=maxValue;
                    var inputValue = $(this).val();
                    if(parseFloat(maxValue)<parseFloat(inputValue)){
                        error++;
                        writtenError=1;
                    }
                });
                $('[name="mcq[]"').each(function () {
                    var maxValue = $(this).attr('max');
                    maxMcq=maxValue;
                    var inputValue = $(this).val();
                    if(parseFloat(maxValue)<parseFloat(inputValue)){
                        error++;
                        mcqError=1;
                    }
                });
                $('[name="practical[]"').each(function () {
                    var maxValue = $(this).attr('max');
                    maxPractical=maxValue;
                    var inputValue = $(this).val();
                    if(parseFloat(maxValue)<parseFloat(inputValue)){
                        error++;
                        practicalError=1;
                    }
                });
                $('[name="ca[]"').each(function () {
                    var maxValue = $(this).attr('max');
                    maxSba=maxValue;
                    var inputValue = $(this).val();
                    if(parseFloat(maxValue)<parseFloat(inputValue)){
                        error++;
                        sbaError=1;
                    }
                });

                if(error) {
                    $('.alertZone').empty();
                    var errorLi = "";

                    if(writtenError){
                        errorLi +='<li>Written mark must be equal or less than '+maxWritten+'</li>';
                    }
                    if(mcqError){
                        errorLi +='<li>MCQ mark must be equal or less than '+maxMcq+'</li>';
                    }
                    if(practicalError){
                        errorLi +='<li>Practical mark must be equal or less than '+maxPractical+'</li>';
                    }
                    if(sbaError){
                        errorLi +='<li>SBA mark must be equal or less than '+maxSba+'</li>';
                    }

//                    console.log(errorLi);
//                    console.log(maxWritten);
                    var alertContents='<div class="alert alert-danger">' +
                        '<button data-dismiss="alert" class="close" type="button">×</button>' +
                        '<ul class="alertItem">'+errorLi+
                        '</ul></div>';
                    $('.alertZone').append(alertContents).show();
                } else {
                    that.submit();
                }
            });
            $('#class').on('change', function (e) {
                var val = $(e.target).val();
                $.ajax({
                    url:'/class/getsubjects/'+val,
                    type:'get',
                    dataType: 'json',
                    success: function( json ) {
                        $('#subject').empty();
                        $('#subject').append($('<option>').text("--Select Subject--").attr('value',""));
                        $.each(json, function(i, subject) {
                            // console.log(subject);

                            $('#subject').append($('<option>').text(subject.name).attr('value', subject.code));
                        });
                    }
                });
            });

            $(".datepicker2").datepicker( {
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years",
                autoclose:true

            }).on('changeDate', function (ev) {
                var aclass = $('#class').val();
                var section =  $('#section').val();
                var shift = $('#shift').val();
                var session = $('#session').val().trim();
                $.ajax({
                    url: '/student/getList/'+aclass+'/'+section+'/'+shift+'/'+session,
                    data: {
                        format: 'json'
                    },
                    error: function(error) {
                        alert(error);
                    },
                    dataType: 'json',
                    success: function(data) {

                        $("#studentList").find("tr:gt(0)").remove();
                        if(data.length>0)
                        {
                            $('#btnsave').show();
                        }
                        for(var i =0;i < data.length;i++)
                        {
                            addRow(data[i],i);
                        }

                    },
                    type: 'GET'
                });

            });

            $( "#subject" ).change(function() {

                $.ajax({
                    url: '/subject/getmarks/'+$('#subject').val()+'/'+$('#class').val(),
                    data: {
                        format: 'json'
                    },
                    error: function(error) {
                        console.log(error);
                    },
                    dataType: 'json',
                    success: function(data) {

                        $('#tfull').text(data[0]['totalfull']);
                        $('#tpass').text(data[0]['totalpass']);

                        $('#wfull').text(data[0]['wfull']);
                        $('#wpass').text(data[0]['wpass']);

                        $('#mfull').text(data[0]['mfull']);
                        $('#mpass').text(data[0]['mpass']);

                        $('#pfull').text(data[0]['pfull']);
                        $('#ppass').text(data[0]['ppass']);

                        $('#cfull').text(data[0]['sfull']);
                        $('#cpass').text(data[0]['spass']);

                        $('[name="written[]"').each(function () {
                            $(this).attr('max',data[0]['wfull']);
                        });
                        $('[name="mcq[]"').each(function () {
                            $(this).attr('max',data[0]['mfull']);
                        });
                        $('[name="practical[]"').each(function () {
                            $(this).attr('max',data[0]['pfull']);
                        });
                        $('[name="ca[]"').each(function () {
                            $(this).attr('max',data[0]['sfull']);
                        });
                    },
                    type: 'GET'
                });

            });



        });
        function addRow(data,index) {
            var table = document.getElementById('studentList');
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            // var cell1 = row.insertCell(0);
            //  var chkbox = document.createElement("label");
            // chkbox.type = "checkbox";
            //chkbox.name="chkbox[]";
            // cell1.appendChild(chkbox);

            var cell2 = row.insertCell(0);
            var regiNo = document.createElement("label");

            regiNo.innerHTML=data['regiNo'];
            cell2.appendChild(regiNo);
            var hdregi = document.createElement("input");
            hdregi.name="regiNo[]";
            hdregi.value=data['regiNo'];
            hdregi.type="hidden";
            cell2.appendChild(hdregi);


            var cell3 = row.insertCell(1);
            var rollno = document.createElement("label");
            rollno.innerHTML=data['rollNo'];
            cell3.appendChild(rollno);
            /*   var hdroll = document.createElement("input");
               hdroll.name="rollNo[]";
               hdroll.value=data['rollNo'];
              hdroll.type="hidden";
              cell3.appendChild(hdroll);*/



            var cell4 = row.insertCell(2);
            var name = document.createElement("label");
            name.innerHTML=data['firstName']+' '+data['middleName']+' '+data['lastName'];
            cell4.appendChild(name);

            var cell5 = row.insertCell(3);
            var written = document.createElement("input");
            written.type="text";

            written.name = "written[]";
            written.required = "true";
            written.size="2";
            written.value="0";
            written.maxlength="2";
            written.class="form-control";
            cell5.appendChild(written);

            var cell6 = row.insertCell(4);
            var mcq = document.createElement("input");
            mcq.type="text";

            mcq.name = "mcq[]";
            mcq.required = "true";
            mcq.size="2";
            mcq.value="0";
            cell6.appendChild(mcq);

            var cell7 = row.insertCell(5);
            var practical = document.createElement("input");
            practical.type="text";

            practical.name = "practical[]";
            practical.required = "true";
            practical.size="2";
            practical.value="0";
            cell7.appendChild(practical);

            var cell8 = row.insertCell(6);
            var ca = document.createElement("input");
            ca.type="text";

            ca.name = "ca[]";
            ca.required = "true";
            ca.size="2";
            ca.value="0";
            cell8.appendChild(ca);

            var cell9 = row.insertCell(7);
            var chkbox = document.createElement("input");
            chkbox.type = "text";
            chkbox.placeholder="No";
            chkbox.name="absent[]";
            chkbox.size="3";
            cell9.appendChild(chkbox);
        };

    </script>

@stop