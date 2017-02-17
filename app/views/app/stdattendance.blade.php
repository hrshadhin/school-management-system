<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Attenace Report</title>


    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/result.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/fonts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/stylesheet.css">
    <script type="text/javascript">
        //<![CDATA[
        var Croogo = {"basePath":"\/","params":{"controller":"student_results","action":"index","named":[]}};
        //]]>
    </script>


<style type="text/css">
.btn-print {
    color: #ffffff;
    background-color: #49b3e2;
    border-color: #aed0df;
    float: right;

    font-size: 40px;
    padding: 5px;
    margin: 10px 10px;
    border-radius: 20px;
}

.btn-print:hover,
.btn-print:focus,
.btn-print:active,
.btn-print.active,
.open .dropdown-toggle.btn-print {
  color: #ffffff;
  background-color: #0F9966;
  border-color: #19910E;
}

.btn-print:active,
.btn-print.active,
.open .dropdown-toggle.btn-print {
  background-image: none;
}

.btn-print .badge {
  color: #34BA1F;
  background-color: #ffffff;
}
.wraperResult{
  height: 100% !important;
}
.signatureWraper{
  position: relative !important;
}
.rgttopleft{
  width: 242px !important;
  border-right: 2px solid #afafaf;
}
.restopleft{
  border-right: 2px solid #afafaf;

}
</style>

</head>

<body class="scms-result-print">
  <button class="btn-print" onclick="printDiv('printableArea')">Print</button>
<div id="printableArea">
  <div class="wraperResult">
    <div class="resHdr">
        <img src="<?php echo url();?>/markssheetcontent/res-logo.png" alt="" class="resLogo">            <div class="schoolIdentity">
            <img src="<?php echo url();?>/markssheetcontent/school-title.png" alt="">                <div class="hdrText">
                <span> SESSION-{{$student->session}}</span>
                <strong> </strong>
            </div><!-- end of hdrText -->
        </div><!-- end of schoolIdentity -->
    </div><!-- end of resHdr -->
    <div class="resContainer">
      <hr>
        <div class="resTophdr">
            <div class="restopleft">
                <div><b>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</b></div>
                <div><span>FATHER'S NAME</span><i>: </i><em>{{$student->fatherName}}</em></div>
                <div><span>MOTHER'S NAME</span><i>: </i><em>{{$student->motherName}}</em></div>
                <div><span>STUDENT ID</span><i>: </i><em>{{$student->regiNo}}</em></div>
                <div><span>DATE OF BIRTH</span><i>: </i><em>{{$student->dob}}</em></div>
                <!--<div><span>NEW CLASS ROLL :  </span><em>02</em></div>-->
                <div><span>SHIFT</span><i>: </i><em>{{$student->shift}}</em></div>
            </div><!-- end of restopleft -->

            <div class="restopleft rgttopleft">
                <div><span>CLASS</span><i>: </i><em>{{$class->name}}</em></div>
                <div><span>GROUP</span><i>: </i><em>{{$student->group}}</em></div>
                <div><span>SECTION</span><i>: </i><em>{{$student->section}}</em></div>
                <div><span>ROLL NO</span><i>: </i><em>{{$student->rollNo}}</em></div>

                <div><span></span><i> </i><em></em></div>

                <div><span></span><i> </i><em></em></div>
                <div><span></span><i> </i><em></em></div>
                <!--<div><span>PROMOTED CLASS : </span><em>9 (B)</em></div>-->
            </div><!-- end of restopleft -->
        </div><!-- end of resTophdr -->
        <hr>
        <div class="resmidcontainer">
          <h2 class="markTitle">Student Attendance Report</h2>
          <table class="pagetble_middle">
            <tr>
              <th>Date</th>
            </tr>
            @foreach($student->attendance as $attend)
             <tr>
               <td>{{$attend->date->format('M j,Y')}}</td>

             </tr>
            @endforeach
          </table>
          <span><strong>Total Days: {{count($student->attendance)}}</strong></span>
        </div><!-- end of resmidcontainer -->

    </div><!-- end of resContainer -->
    <div class="signatureWraper"><div class="signatureCont">
            <div class="sign-grdn"><b>Signature (Guardian)</b></div>
            <div class="sign-clsT"><b>Signature (Class Teacher)</b></div>
            <div class="sign-head">
                <!--<img src="<?php echo url();?>/markssheetcontent/head-sign.png" alt="" style="left:23px;bottom:21px">-->                <b>Signature (Head Master)</b>
            </div>
        </div></div><!-- end of signatureWraper -->
  </div>


   <script>
   function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

   }

   </script>
</body><!-- end of fromwrapper-->
</html>
