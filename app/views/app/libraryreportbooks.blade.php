

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>

.bg{
 width: 100%;
 background-color:#dcdcdc;
}
.bg2{
 width: 100%;
background-color:#cccccc;
}
.bg3{
  width: 100%;

}
.bg3 tr:nth-child(even) {
    background-color: #81DAF5;
}
.bg3 tr:nth-child(odd) {
    background-color: #82FA58;
}

table {
border-spacing: 0;
border-collapse: separate;

}
table td{
padding-left: 5px;
}
.thead td{
  border-bottom: solid green 2px;
  font-weight: bold;
  color:blue;
}
.red
{
  color:red;
  font-weight: bold;
}
.green {
  color:green;
  font-weight: bold;
}
.logo{
  height: 150px;
  width: 200px;
}
.lefthead{
  width: 30%;
}
.righthead{
  width: 70%;
}
.righthead p{
  margin: 0px;
  padding: 0px;
}
#footer
{

width:100%;
height:50px;
position:absolute;
bottom:0;
left:0;
}
</style>
</head>

<body >
<div id="admit">
  <table class="bg">
    <tr>
    <td class="lefthead">

     <img class="logo" src="./img/logo.png">
    </td>

   <td class="righthead">
     <h3>{{$institute->name}}</h3><pre>
<p><strong>Establish:</strong> {{$institute->establish}}</p>
<p><strong>Web:</strong> {{$institute->web}}</p>
<p><strong>Email:</strong> {{$institute->email}}</p>
<p><strong>Phone:</strong> {{$institute->phoneNo}}</p>
<p><strong>Address:</strong> {{$institute->address}}</p>
     </pre>
   </td>
   </tr>

 </table>
 <table class="bg2">
   <tr><td>
    Library Report
  </td>
  <td><strong>{{$rdata['name']}}</strong></td>
  <td >

  </td>
</tr>
</table>
<br>
<table class="bg3">

    <tr class="thead">
        <td>Name</td>
        <td>Code</td>
        <td>Author </td>
        <td>Quantity </td>

        <td>Rack No</td>
        <td>Row No</td>
        <td>Description</td>


    </tr>

    @foreach($datas as $data)
        <tr>
            <td>{{$data->title}}</td>
            <td>{{$data->code}}</td>
            <td>{{$data->author}}</td>
            <td>{{$data->quantity}}</td>

            <td>{{$data->rackNo}}</td>
            <td>{{$data->rowNo}}</td>
            <td>{{$data->desc}}</td>

        </tr>



    @endforeach



</table>

<hr>
<table>
 <tr>  <td><strong>Total:</strong></td><td>{{$rdata['total']}}</td><td></td><td></td> <tr>
</table>

<div id="footer">
  <p>Print Date: {{date('d/m/Y')}}</p>
</div>
</body>
</html>
