<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font: 12pt "Tahoma";
}
* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.page {
    width: 21cm;
    min-height: 29.7cm;
    padding: 0.5cm;
    margin: 1cm auto;
    border: 1px #D3D3D3 solid;
    border-radius: 5px;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}


@page {
    size: A4;
    margin: 0;
}
@media print {
    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}


.barcode{
  margin-left:50px;
}
.barcode1st{
  margin-left:18px;
}

.btn{
	text-decoration:none;
	color:#fff;
	font-size:25px;
	font-weight:bold;
	padding:0 15px;
	line-height:50px;
	height: auto;
	display:inline-block;
	text-align:center;
	background-color:#DDDDDD;
  top: 0;
z-index: 100;
position: fixed;

}
.btn.green{
  left:0;
	background-color:#4BC94D;
}

.btn.green:hover{
	background-color:#6fd471;
}

.btn.blue{
  right: 0;
	background-color:#5DADE2;
}

.btn.blue:hover{
	background-color:#7dbde8;
}

.btn:hover{
	background-color:#F6F6F6;
}



.btn.pill{
  -webkit-border-radius: 16px;
  -moz-border-radius: 16px;
  border-radius: 16px;
}
p{
  margin-top:0;
  margin-bottom:20px;
}
.plast p:last-child{
  margin:0 !important;
}
</style>
</head>

<body >
  <div id="book" class="book">
      <div id="page" class="page">
        <table>
          <tr><td>
            <div class="barcode1st plast">
              @foreach($barcodesc1 as $barcode)

                <img src="data:image/png;base64,{{$barcode['img']}}">
                <p>{{$barcode['code'][0]}}&nbsp;&nbsp;{{$barcode['code'][1]}}&nbsp;&nbsp;{{$barcode['code'][2]}}
                &nbsp;&nbsp;{{$barcode['code'][3]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][4]}}&nbsp;&nbsp;&nbsp;
                {{$barcode['code'][5]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][6]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][7]}}
                &nbsp;&nbsp;&nbsp;{{$barcode['code'][8]}}&nbsp;&nbsp;{{$barcode['code'][9]}} </p>

              @endforeach

          </div>
         </td>
         <td>
          <div class="barcode plast">
            @foreach($barcodesc2 as $barcode)

              <img src="data:image/png;base64,{{$barcode['img']}}">
              <p>{{$barcode['code'][0]}}&nbsp;&nbsp;{{$barcode['code'][1]}}&nbsp;&nbsp;{{$barcode['code'][2]}}
              &nbsp;&nbsp;{{$barcode['code'][3]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][4]}}&nbsp;&nbsp;&nbsp;
              {{$barcode['code'][5]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][6]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][7]}}
              &nbsp;&nbsp;&nbsp;{{$barcode['code'][8]}}&nbsp;&nbsp;{{$barcode['code'][9]}} </p>

            @endforeach
         </div>
         </td>
         <td >
           <div class="barcode plast">
             @foreach($barcodesc3 as $barcode)

               <img src="data:image/png;base64,{{$barcode['img']}}">
               <p>{{$barcode['code'][0]}}&nbsp;&nbsp;{{$barcode['code'][1]}}&nbsp;&nbsp;{{$barcode['code'][2]}}
               &nbsp;&nbsp;{{$barcode['code'][3]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][4]}}&nbsp;&nbsp;&nbsp;
               {{$barcode['code'][5]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][6]}}&nbsp;&nbsp;&nbsp;{{$barcode['code'][7]}}
               &nbsp;&nbsp;&nbsp;{{$barcode['code'][8]}}&nbsp;&nbsp;{{$barcode['code'][9]}} </p>

             @endforeach
         </div>
         </td>
       </tr>
       </table>
      </div>

  </div>
  <a class="btn green pill" href="/barcode">Generate More</a>
  <button class="btn blue pill" onclick="printDiv()">Print</button>

  <script>
  function printDiv() {
    var printContents = document.getElementById('book').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;




  }

  </script>
</body>
</html>
