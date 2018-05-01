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
  <div class="row">
  <div class="box col-md-12">
          <div class="box-inner">
              <div data-original-title="" class="box-header well">
                  <h2><i class="glyphicon glyphicon-print"></i> Admit Card Print</h2>

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

                <form role="form" action="/printadmitcard" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="refNo">Referance No:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <input type="text" class="form-control" required name="refNo">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="transactionNo">bkash Transaction No:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                <input type="text" class="form-control" required  name="transactionNo">
                            </div>
                        </div>
                      </div>

                    </div>
                  </div>



                      <div class="clearfix"></div>

                    <div class="form-group pull-right">
                    <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-print"></i> Print Admit Card</button>

                    </div>
                      <div class="clearfix"></div>
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
