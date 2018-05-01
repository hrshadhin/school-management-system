<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        #admit{
            height:510px;
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
            width: 30%;
        }
        #info
        {
            width: 70%;
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
<p><strong>Admit card</strong></p>
<p><strong>Admission test for class {{$data->class}}</strong></p>
<p><strong>Session:</strong>{{$data->session}}</p>
<p><strong>Established:</strong> {{$institute->establish}}</p>
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
           <!--     Applicant's Copy-->
            </td>
         <!--    <td>{{$data->class}} Admission Exam(Session:{{$data->session}})</td>-->
            <td >
         <!--   <strong>Admit Card</strong> -->
            </td>
        </tr> 
    </table>

    <table class="bg3">
        <tr>
            <td id="info">
                <table width="100%">
                    <tr>
                        <td width="40%">Applicant's Name </td>
                        <td width="10%">:</td>
                        <td width="50%"> {{$data->stdName}} </td>
                    </tr>

                    <tr>

                        <td width="40%">Father's Name </td>
                        <td width="10%">:</td>
                        <td width="50%"> {{$data->fatherName}} </td>
                    </tr>
					<tr>
                        <td width="40%">Mother's Name</td>
                        <td width="10%">:</td>
                        <td width="50%"> {{$data->motherName}} </td>
                    </tr>                    
                    <tr>
                        <td width="40%">Date Of Birth</td>
                        <td width="10%">:</td>
                        <td width="50%"> {{$data->dob}} </td>
                    </tr>
                    <tr>
                        <td width="40%">Roll No </td>
                        <td width="10%">:</td>
                        <td width="50%"> {{$data->seatNo}} </td>
                    </tr>
                    <tr>
                        <td width="40%">Date of exam</td>
                        <td width="10%">:</td>
                        <td width="50%"> --- </td>
                    </tr>
                    <tr>
                        <td>Vanue</td>
                        <td>:</td>
                        <td>St. Joseph’s High School</td>
                    </tr>
                </table>
            </td>

            <td id="pic" style="text-align: right;">
                <img style="float:right; width:160px; height:150px; vertical-align: top;padding:0px 5px 0px 0px;margin: 0;" src="./admission/{{$data->photo}}">
            </td>

        </tr>
        <tr>
            <td class="content">
                <img  style="float:left; width:100px; height:50px;" src="./img/head-sign.png">
            </td>
            <td class="content" style="text-align: right;">
                <img  style="float:right; width:100px; height:50px;padding:0px 5px 0px 0px;margin: 0;" src="./admission/{{$data->signature}}">
            </td>
        </tr>
        <tr>

            <td style="vertical-align:top;width:50%;text-align: left" >
                Signature Of Authority
            </td>
            <td style="vertical-align:top;width:50%;text-align: right" >
                <span style="padding:0px 5px 0px 0px;">Signature Of Applicant</span>
            </td>

        </tr>
    </table>
    <p style="text-align:center">This Admit Card is Electronically Produced.</p>
	<p style="text-align:right;margin-right:10px;">Software develop by: <strong>www.scenic-software.com<strong></p>
    <p>&nbsp;</p>
</div>
</body>
</html>
