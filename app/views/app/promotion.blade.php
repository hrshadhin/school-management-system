@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>{{ Session::get('success')}}</strong>

        </div>
    @endif
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div data-original-title="" class="box-header well">
                    <h2><i class="glyphicon glyphicon-user"></i> Promotion </h2>

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
                    <form role="form" action="/promotion" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box col-md-6">
                                    <div class="box-inner">
                                        <div class="box-header well" data-original-title="">
                                            <h2><i class="glyphicon glyphicon-edit"></i> Promotion From</h2>

                                        </div>
                                        <div class="box-content">
                                            <div class="row">
                                                <div class="col-md-12">


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label" for="class">Class</label>

                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                                <select id="class" name="class" class="form-control" >
                                                                    @foreach($classes as $class)
                                                                        <option value="{{$class->code}}">{{$class->name}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
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

                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label for="session">session</label>
                                                            <div class="input-group">

                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                                <input type="text" id="session" required="true" class="form-control datepicker2" name="session"   data-date-format="yyyy">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box col-md-6">
                                    <div class="box-inner">
                                        <div class="box-header well" data-original-title="">
                                            <h2><i class="glyphicon glyphicon-edit"></i> Promotion To</h2>


                                        </div>
                                        <div class="box-content">

                                            <div class="row">
                                                <div class="col-md-12">


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label" for="class">Class</label>

                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                                <select id="class" name="nclass" class="form-control" >
                                                                    @foreach($classes as $class)
                                                                        <option value="{{$class->code}}">{{$class->name}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label" for="section">Section</label>

                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                                <select id="section" name="nsection"  class="form-control" >
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label" for="shift">Shift</label>

                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                                <select id="shift" name="nshift"  class="form-control" >
                                                                    <option value="Day">Day</option>
                                                                    <option value="Morning">Morning</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group ">
                                                            <label for="session">session</label>
                                                            <div class="input-group">

                                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                                <input type="text" id="nsession" required="true" class="form-control datepicker" name="nsession"   data-date-format="yyyy">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
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
                                            <th><input type="checkbox" id="allcheck" name="allcheck"> SL#</th>
                                            <th>Registration No</th>
                                            <th>Roll No</th>
                                            <th>Name</th>
                                            <th>New Roll No</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        <tbody>
                                    </table>
                                </div>
                            </div>

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
            $(".datepicker").datepicker({
                format: " yyyy", // Notice the Extra space at the beginning
                viewMode: "years",
                minViewMode: "years",
                autoclose:true

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
                    url: '/subject/getmarks/'+$('#subject').val(),
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
                    },
                    type: 'GET'
                });

            });



        });
        $('#allcheck').change(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);

        });




        function addRow(data,index) {
            var table = document.getElementById('studentList');
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
             var cell1 = row.insertCell(0);
            var chkbox = document.createElement("input");
             chkbox.type = "checkbox";
            chkbox.name="promot["+data['regiNo']+"]";
            chkbox.class="checkMe";
            cell1.appendChild(chkbox);

            var cell2 = row.insertCell(1);
            var regiNo = document.createElement("label");

            regiNo.innerHTML=data['regiNo'];
            cell2.appendChild(regiNo);
            var hdregi = document.createElement("input");
            hdregi.name="regiNo[]";
            hdregi.value=data['regiNo'];
            hdregi.type="hidden";
            cell2.appendChild(hdregi);


            var cell3 = row.insertCell(2);
            var rollno = document.createElement("label");
            rollno.innerHTML=data['rollNo'];
            cell3.appendChild(rollno);
            /*   var hdroll = document.createElement("input");
             hdroll.name="rollNo[]";
             hdroll.value=data['rollNo'];
             hdroll.type="hidden";
             cell3.appendChild(hdroll);*/



            var cell4 = row.insertCell(3);
            var name = document.createElement("label");
            name.innerHTML=data['firstName']+' '+data['middleName']+' '+data['lastName'];
            cell4.appendChild(name);



            var cell5 = row.insertCell(4);
            var nrollno = document.createElement("input");
            nrollno.type = "text";
            nrollno.name="newrollNo["+data['regiNo']+"]";
            nrollno.size="3";
            cell5.appendChild(nrollno);
        };

    </script>

@stop
