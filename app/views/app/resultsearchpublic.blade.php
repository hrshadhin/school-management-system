
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>School Manage</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- The styles -->
        <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">
        <link href="css/charisma-app.css" rel="stylesheet">

        <script src="bower_components/jquery/jquery.min.js"></script>


        <link rel="shortcut icon" href="img/favicon.ico">

    </head>

    <body>
    <div class="ch-container">
      @if (Session::get('success'))
      <div class="alert alert-danger">
          <strong>{{ Session::get('success')}}</strong>
      </div>
      @endif
      @if (Session::get('noresult'))
          <div class="alert alert-warning">
              <button data-dismiss="alert" class="close" type="button">×</button>
              <strong>{{ Session::get('noresult')}}</strong>

          </div>
      @endif


                            <div class="row">
                                <div class="box col-md-12">
                                    <div class="box-inner">
                                        <div data-original-title="" class="box-header well">
                                            <h2><i class="glyphicon glyphicon-book"></i> Result Search</h2>

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

                                            <form role="form" action="/results" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label" for="class">Class</label>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home blue"></i></span>
                                                                    <select name="class" id="class" class="form-control" required>
                                                                        @foreach($classes as $class)
                                                                            <option value="{{$class->code}}">{{$class->name}}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label for="session">Regi No</label>
                                                                <div class="input-group">

                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                                                    <input type="text" id="regiNo" required="true" class="form-control" name="regiNo">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label" for="exam">Examination</label>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                                                    <?php  $data=[
                                                                            'Class Test'=>'Class Test',
                                                                            'Model Test'=>'Model Test',
                                                                            'First Term'=>'First Term',
                                                                            'Mid Term'=>'Mid Term',
                                                                            'Final Exam'=>'Final Exam'
                                                                    ];?>
                                                                    {{ Form::select('exam',$data,$formdata->exam,['class'=>'form-control','required'=>'true'])}}


                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Search</button>

                                                    </div>
                                                </div>
                                            </form>



                                        </div>
                                    </div>
                                </div>
                            </div>







    </div><!--/.fluid-container-->

    <!-- external javascript -->

    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        $( document ).ready(function() {


        });

    </script>
    </body>
    </html>
