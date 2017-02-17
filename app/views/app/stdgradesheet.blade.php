<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Marks Sheet</title>


    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/result.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/fonts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/markssheetcontent/stylesheet.css">
    <script type="text/javascript">
        //<![CDATA[
        var Croogo = {"basePath":"\/","params":{"controller":"student_results","action":"index","named":[]}};
        //]]>
    </script>

    <script type="text/javascript" src="<?php echo url();?>/markssheetcontent/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="<?php echo url();?>/markssheetcontent/js.js"></script>
    <script type="text/javascript" src="<?php echo url();?>/markssheetcontent/admin.js"></script>

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
</style>

</head>

<body class="scms-result-print">
  <button class="btn-print" onclick="printDiv('printableArea')">Print</button>
<div id="printableArea">
  <div class="wraperResult">
    <div class="resHdr">
        <img src="<?php echo url();?>/markssheetcontent/res-logo.png" alt="" class="resLogo">            <div class="schoolIdentity">
            <img src="<?php echo url();?>/markssheetcontent/school-title.png" alt="">                <div class="hdrText">
                <span>{{$extra[0]}} EXAMINATION-{{$student->session}}</span>
                <strong>{{$student->class}} / Equivalent Result Publication {{$student->session}} </strong>
            </div><!-- end of hdrText -->
        </div><!-- end of schoolIdentity -->
    </div><!-- end of resHdr -->

    <div class="resContainer">
        <div class="resTophdr">
            <div class="restopleft">
                <div><b>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</b></div>
                <div><span>FATHER'S NAME</span><i>: </i><em>{{$student->fatherName}}</em></div>
                <div><span>MOTHER'S NAME</span><i>: </i><em>{{$student->motherName}}</em></div>
                <div><span>STUDENT ID</span><i>: </i><em>{{$student->regiNo}}</em></div>
                <div><span>DATE OF BIRTH</span><i>: </i><em>{{$student->dob}}</em></div>
                <!--<div><span>NEW CLASS ROLL :  </span><em>02</em></div>-->
                <div><span>SHIFT</span><i>: </i><em>{{$student->shift}}</em></div>
                <div><span>BOARD</span><i>: </i><em>KHULNA</em></div>
            </div><!-- end of restopleft -->

            <div class="restopleft rgttopleft">
                <div><span>CLASS</span><i>: </i><em>{{$student->class}}</em></div>
                <div><span>GROUP</span><i>: </i><em>{{$student->group}}</em></div>
                <div><span>SECTION</span><i>: </i><em>{{$student->section}}</em></div>
                <div><span>ROLL NO</span><i>: </i><em>{{$student->rollNo}}</em></div>

                <div><span>GPA</span><i>: </i><em>{{$meritdata->point}}</em></div>

                <div><span>GRADE</span><i>: </i><em>{{$meritdata->grade}}</em></div>
                <div><span>MERIT POSITION</span><i>: </i><em>{{$meritdata->position}}TH</em></div>
                <!--<div><span>PROMOTED CLASS : </span><em>9 (B)</em></div>-->
            </div><!-- end of restopleft -->
        </div><!-- end of resTophdr -->


        <div class="resmidcontainer">
            <h2 class="markTitle">Subject-Wise Grade &amp; Mark Sheet</h2>
            <table class="pagetble_middle">
                <tbody><tr>
                    <th class="res1" rowspan="2">CODE</th>
                    <th class="res2 cTitle" rowspan="2">SUBJECT</th>

                    <th class="res8 examtitle" colspan="12">{{$extra[0]}} EXAMINATION MARKS</th>
                    <!--<th class="res3 examtitle" colspan="6">Final EXAMINATION MARKS</th>-->
                </tr>

                <tr>
                    <!--<td class="res1">&nbsp;</td>
                    <td class="res2">&nbsp;</td>
                    <td class="res1">Total</td>
                    <td class="res1">GP</td>
                    <td class="res3">Highest</td>-->
                    <td class="res7" colspan="2">Written</td>
                    <td class="res7" colspan="2">MCQ</td>
                    <td class="res7" colspan="2">SBA</td>
                    <td class="res7" colspan="2">Practical</td>
                    <td class="res5">Total</td>
                    <td class="res5">Highest</td>
                    <td class="res4">GP</td>
                    <td class="res3">Grade</td>
                    <!--<td class="res3">Written</td>
                    <td class="res4">MCQ</td>
                    <td class="res5">SBA</td>
                    <td class="res3">Total</td>
                    <td class="res3">GP</td>
                    <td class="res6">Grade</td>-->
                </tr>

                <tr>
                    @if($extra[1])

                    <td>{{$banglaArray[0][0]}}</td>
                    <td class="cTitle">{{$banglaArray[0][1]}}</td>

                    <td><b>{{$banglaArray[0][2]}}</b></td>
                    <td rowspan="2"><b>{{$banglaArray[0][2]+$banglaArray[1][2]}}</b></td>

                    <td><b>{{$banglaArray[0][3]}}</b></td>
                    <td rowspan="2"><b>{{$banglaArray[0][3]+$banglaArray[1][3]}}</b></td>

                    <td><b>{{$banglaArray[0][4]}}</b></td>
                    <td rowspan="2"><b>{{$banglaArray[0][4]+$banglaArray[1][4]}}</b></td>

                    <td><b>{{$banglaArray[0][5]}}</b></td>
                    <td rowspan="2"><b>{{$banglaArray[0][5]+$banglaArray[1][5]}}</b></td>


                    <td rowspan="2"><b>{{$blextra[0]}}</b></td>
                    <td rowspan="2"><b>{{$blextra[1]}}</b></td>
                    <td rowspan="2"><b>{{$blextra[2]}}</b></td>
                    <td rowspan="2"><b>{{$blextra[3]}}</b></td>


                    <!--<td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>-->
                </tr>                    <tr>
                    <td>{{$banglaArray[1][0]}}</td>
                    <td class="cTitle">{{$banglaArray[1][1]}}</td>

                    <td><b>{{$banglaArray[1][2]}}</b></td>

                    <td><b>{{$banglaArray[1][3]}}</b></td>

                    <td><b>{{$banglaArray[1][4]}}</b></td>

                    <td><b>{{$banglaArray[1][5]}}</b></td>


                    <!--<td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>-->
                </tr>
                @endif
                @if($extra[3])

                    <td>{{$englishArray[0][0]}}</td>
                    <td class="cTitle">{{$englishArray[0][1]}}</td>

                    <td><b>{{$englishArray[0][2]}}</b></td>
                    <td rowspan="2"><b>{{$englishArray[0][2]+$englishArray[1][2]}}</b></td>

                    <td><b>{{$englishArray[0][3]}}</b></td>
                    <td rowspan="2"><b>{{$englishArray[0][3]+$englishArray[1][3]}}</b></td>

                    <td><b>{{$englishArray[0][4]}}</b></td>
                    <td rowspan="2"><b>{{$englishArray[0][4]+$englishArray[1][4]}}</b></td>

                    <td><b>{{$englishArray[0][5]}}</b></td>
                    <td rowspan="2"><b>{{$englishArray[0][5]+$englishArray[1][5]}}</b></td>


                    <td rowspan="2"><b>{{$enextra[0]}}</b></td>
                    <td rowspan="2"><b>{{$enextra[1]}}</b></td>
                    <td rowspan="2"><b>{{$enextra[2]}}</b></td>
                    <td rowspan="2"><b>{{$enextra[3]}}</b></td>


                    <!--<td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>-->
                    </tr>                    <tr>
                        <td>{{$englishArray[1][0]}}</td>
                        <td class="cTitle">{{$englishArray[1][1]}}</td>

                        <td><b>{{$englishArray[1][2]}}</b></td>

                        <td><b>{{$englishArray[1][3]}}</b></td>

                        <td><b>{{$englishArray[1][4]}}</b></td>

                        <td><b>{{$englishArray[1][5]}}</b></td>


                        <!--<td><b>&nbsp;</b></td>
                        <td><b>&nbsp;</b></td>
                        <td><b>&nbsp;</b></td>
                        <td><b>&nbsp;</b></td>
                        <td><b>&nbsp;</b></td>
                        <td><b>&nbsp;</b></td>-->
                    </tr>
                @endif

                @foreach($subcollection as $subject)
                <tr>
                    <td>{{$subject->subcode}}</td>
                    <td class="cTitle">{{$subject->subname}}</td>
                    <td colspan="2"><b>{{$subject->written}}</b></td>
                    <td colspan="2"><b>{{$subject->mcq}}</b></td>
                    <td colspan="2"><b>{{$subject->ca}}</b></td>
                    <td colspan="2"><b>{{$subject->practical}}</b></td>


                    <td><b>{{$subject->total}}</b></td>
                    <td><b>{{$subject->highest}}</b></td>
                    <td><b>{{$subject->point}}</b></td>
                    <td><b>{{$subject->grade}} </b></td>








                    <!--<td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>-->
                </tr>
              @endforeach
                <tr>

                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2"><b>&nbsp;</b></td>
                    <td colspan="2"><b>&nbsp;</b></td>
                    <td colspan="2"><b>&nbsp;</b></td>
                    <td colspan="2"><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <!--<td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>-->
                </tr>
                <tr class="lastitem">
                    <td>&nbsp;</td>
                    <td class="markTotal" colspan="9">Total Marks &amp; GPA = </td>
                    <td><b>{{intval($meritdata->totalNo)}}</b></td>
                    <td><b>{{$extra[2]}}</b></td>
                    <td><b>{{$meritdata->point}}</b></td>
                    <td><b>{{$meritdata->grade}}</b></td>
                    <!--<td class="res3 markTotal2" colspan="3">Total marks &amp; GPA</td>
                    <td class="res3"><b>&nbsp;</b></td>
                    <td class="res3"><b>&nbsp;</b></td>
                    <td class="res6"><b>&nbsp;</b></td>-->
                </tr>

                </tbody></table>
        </div><!-- end of resmidcontainer -->

        <div class="btmcontainer">
            <div class="overalreport overalreportAll">
                <h2 class="markTitle">Overall Report</h2>
                <table class="pagetble" style="height:113px">
                    <tbody><tr>
                        <th class="column1" style="width:110px; padding:3px 0 2px">Subject Code</th>
                        <th class="column2" style="width:130px">Total Marks</th>
                        <th class="column3">Gp</th>
                    </tr>
                    @if($extra[1])
                    <tr>


                        <td class="column1" style="width:110px; text-align:center">{{$banglaArray[0][0]}}</td>
                        <td class="column2" style="width:130px">{{$blextra[0]}}</td>
                        <td class="column3"><b>{{$blextra[2]}}</b></td>
                    </tr>
                    @endif
                    @if($extra[3])
                        <tr>


                            <td class="column1" style="width:110px; text-align:center">{{$englishArray[0][0]}}</td>
                            <td class="column2" style="width:130px">{{$enextra[0]}}</td>
                            <td class="column3"><b>{{$enextra[2]}}</b></td>
                        </tr>
                    @endif
                    @foreach($subcollection as $subject)

                        <tr>


                            <td class="column1" style="width:110px; text-align:center">{{$subject->subcode}}</td>
                            <td class="column2" style="width:130px">{{$subject->total}}</td>
                            <td class="column3"><b>{{$subject->point}}</b></td>
                        </tr>

                        @endforeach

                    <tr>
                        <td class="column1" style="width:110px">&nbsp;</td>
                        <td class="column2" style="width:130px">&nbsp;</td>
                        <td class="column3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="column1" style="width:110px;height:23px;text-align:center">Overall</td>
                        <td class="column2" style="width:130px;height:23px">{{intval($meritdata->totalNo)}}</td>
                        <td class="column3" style="height:23px"><b>{{$meritdata->point}}</b></td>
                    </tr>
                    </tbody></table>
            </div><!-- end of overalreport -->

            <div class="overalreport attendenceReport">
                <h2 class="markTitle">Attendance Report</h2>
                <table class="pagetble" style="height:181px">
                    <tbody><tr>
                        <th colspan="2">Month : Presence</th>
                    </tr>

                    @for($i = 0; $i < 12; $i=$i+2)
                    <tr>
                        <td>{{$attendance[$i]->month}} : {{$attendance[$i]->present}}</td>
                        <td>{{$attendance[$i+1]->month}} : {{$attendance[$i+1]->present}}</td>

                    </tr>
                  @endfor
                  </tbody></table>

                <h2 class="markTitle">Extra Activities </h2>
                <table class="pagetble" style="height:106px"><tbody>
                    <tr><td>{{$extra[4]}}</td></tr>	</tbody></table>
            </div><!-- end of overalreport -->

            <div class="overalreport gpagrading">
                <h2 class="markTitle">GPA Grading</h2>
                <table class="pagetble" style="height:181px">
                    <tbody><tr>
                        <th class="column1">Range of Marks(%)</th>
                        <th class="column2">Grade</th>
                        <th class="column3">Point</th>
                    </tr>
                    <tr>
                        <td class="column1">80 or Above </td>
                        <td class="column2"> A+</td>
                        <td class="column3">5.00</td>
                    </tr>
                    <tr>
                        <td class="column1">70 to 79</td>
                        <td class="column2">A</td>
                        <td class="column3">4.00</td>
                    </tr>
                    <tr>
                        <td class="column1">60 to 69</td>
                        <td class="column2">A-</td>
                        <td class="column3">3.50</td>
                    </tr>
                    <tr>
                        <td class="column1">50 to 59</td>
                        <td class="column2">B</td>
                        <td class="column3">3.00</td>
                    </tr>

                    <tr>
                        <td class="column1">40 to 49</td>
                        <td class="column2">C</td>
                        <td class="column3">2.00</td>
                    </tr>

                    <tr>
                        <td class="column1">33 to 39</td>
                        <td class="column2">D</td>
                        <td class="column3">1.00</td>
                    </tr>
                    <tr class="lastitem">
                        <td class="column1">Below 33</td>
                        <td class="column2">F</td>
                        <td class="column3">0.00</td>
                    </tr>
                    </tbody></table>

                <h2 class="markTitle">Achievement</h2>
                <table class="pagetble" style="height:106px"><tbody>
                    <tr><th align="center" valign="middle">{{$extra[0]}}</th><th align="center" valign="middle">
                      @if($meritdata->grade!="F")
                        @if($meritdata->point>=5.00)
                        Excellent
                        @elseif($meritdata->point>=4.00)
                        Good
                        @elseif($meritdata->point>="3.00")
                        Average
                        @elseif($meritdata->point>="2.00")
                        Poor
                        @else
                        Fail
                        @endif
                      @else
                        Fail
                      @endif

                    </th></tr>                    </tbody></table>
            </div><!-- end of overalreport -->

        </div><!-- end of resmidcontainer -->
    </div><!-- end of resContainer -->
    <div class="signatureWraper"><div class="signatureCont">
            <div class="sign-grdn"><b>Signature (Guardian)</b></div>
            <div class="sign-clsT"><b>Signature (Class Teacher)</b></div>
            <div class="sign-head">
                <!--<img src="<?php echo url();?>/markssheetcontent/head-sign.png" alt="" style="left:23px;bottom:21px">-->                <b>Signature (Head Master)</b>
            </div>
        </div></div><!-- end of signatureWraper -->
    <img src="<?php echo url();?>/markssheetcontent/certificate-bg.png" alt="" class="result-bg">    </div><!-- end of wraperResult -->
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
