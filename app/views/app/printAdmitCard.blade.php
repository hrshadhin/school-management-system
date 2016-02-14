<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
  #admit{
     height:480px;
     background-color:#dcdcdc;
   }
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
    background-color:#dcdcdc;
 }
 #pic{
   width: 40%;
 }
 #info
 {
   width: 60%;
 }
table {
border-spacing: 0;
border-collapse: separate;

}
table td{
  padding-left: 5px;
}
.content{
    text-align:left;
}
.content img{
    vertical-align:bottom;
    margin: 0px;
}
</style>
</head>

<body >
<div id="admit">
  <table class="bg">
    <tr><td>
     <img src="./img/logo.png">
   </td>
   <td>&nbsp;</td>
   <td >
     <h3>HR Residential Model School & College</h3><p>Ranirbandar, Chirirbandar, Dinajpur. EST:2011 EIIN No:137042</p><p>Class {{$data->class}} Admission Exam(Session:{{$data->session}})</p>
   </td>
 </tr>
 </table>
 <table class="bg2">
   <tr><td>
    Applicant's Copy
  </td>
  <td>&nbsp;&nbsp;&nbsp;</td>
  <td >
    <strong>Admit Card</strong>
  </td>
</tr>
</table>

<table class="bg3">
  <tr>
    <td id="info">
      <table>
        <tr>
          <td>Roll No</td>
          <td>:</td>
          <td> {{$data->seatNo}} </td>
          </tr>
        <tr>
          <td>Campus</td>
          <td>:</td>
          <td> {{$data->campus}} </td>
          </tr>
        <tr>

          <td>Class </td>
          <td>:</td>
          <td> {{$data->class}} </td>
          </tr>
          <tr>
            <td>Full Name </td>
              <td>:</td>
              <td> {{$data->stdName}} </td>
              </tr>
              <tr>
                <td>Father's Name</td>
                <td>:</td>
                <td> {{$data->fatherName}} </td>
                </tr>
                <tr>
                  <td>Mother's Name</td>
                  <td>:</td>
                  <td> {{$data->motherName}} </td>
                  </tr>
                  <tr>
                    <td>Date Of Birth</td>
                    <td>:</td>
                    <td> {{$data->dob}} </td>
                    </tr>
        </table>
     </td>

    <td id="pic">
       <img style="float:left; width:160px; height:150px;" src="./admission/{{$data->photo}}">
     </td>

  </tr>
  <tr>

    <td class="content">
          <br>
    <img src="./img/signature.png">
    </td>
  </tr>
  <tr>

    <td style="vertical-align:top;width:100%" >
       Signature Of Authority&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This Admit Card is Electronically Produced.
    </td>

  </tr>
 </table>
<p style="color:red;text-align:center">Admission test will be held on 8th January at Campus 2.</p>
<p style="text-align:right;margin-right:10px;">Software develop by-<strong>Supersoft Corporation<strong></p>
</div>
</body>
</html>

