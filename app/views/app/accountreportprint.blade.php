<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Account-Report({{$formdata[2]}})</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- The styles -->
    <link id="bs-css" href="<?php echo url();?>/css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?php echo url();?>/css/charisma-app.css" rel="stylesheet">
    <style>
    #footer
    {

    width:100%;
    height:50px;
    position:absolute;
    bottom:0;
    left:0;
    }
    .logo{
      height:80px;
      width: 100px;
    }
    </style>
    </head>
<body>
<div id="printableArea">
  <div class="row text-center">

  <div class="col-md-1 col-sm-1">
  <img class="logo" src="{{url()}}/img/logo.png">
  </div>
    <div class="col-md-11 col-sm-11">
        <h4><strong>"{{$institute->name}}" Accounting Report</strong></h4>
        <h5><strong>Establish:</strong> {{$institute->establish}}  <strong>Web:</strong> {{$institute->web}}  <strong>Email:</strong> {{$institute->email}}</h5>
        <h5><strong>Phone:</strong> {{$institute->phoneNo}} <strong>Address:</strong> {{$institute->address}}</h5>
      </div>



  </div>

<div class="row">
    <div class="col-md-12 text-center">
       <h5> <strong>Type:</strong> {{$formdata[2]}} </h5>


    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <h5><strong>Time Period: </strong> {{$formdata[0]}} <strong>To</strong> {{$formdata[1]}}</h5>

    </div>
</div>
<hr>
        <div  class="row">
            <div class="col-md-12">
                <table id="" class="table table-striped table-bordered table-hover">

                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->amount}}</td>
                            <td>{{$data->description}}</td>
                            <td>{{date_format(date_create($data->date), 'd/m/Y');}}</td>
                        </tr>



                    @endforeach
                    <td class="text-right"><strong>Total:</strong></td><td>{{$total[0]->total}}</td><td></td><td></td>
                    </tbody>
                </table>
            </div>

        </div>

  <div id="footer">
      <p>Print Date: {{date('d/m/Y')}}</p>
  </div>
</div>
    <button class="btn btn-success pull-right" onclick="printDiv('printableArea')"><i class="glyphicon glyphicon-print"></i> Print</button>
<script src="<?php echo url();?>/bower_components/jquery/jquery.min.js"></script>
<script src="<?php echo url();?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;

}

</script>
</body>
</html>
