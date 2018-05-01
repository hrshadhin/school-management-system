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
        .achivement{
            text-align: center;
            margin-left: 25%;
            margin-right: 25%;
        }
        .achivement table{
            width: 100%;
            height: 110px;
            text-transform: none !important;
        }
        .achivement table th{
            text-transform: none;
            font-weight: bold;
        }
        .achivement .childTable{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        .achivement .childTable td{
            border: none;
            border-bottom: solid #000 1px;
            height: 30px;
            text-transform: none !important;
            font-size: 16px;
        }
        .gpaTile{
            font-size: 13px;
            font-family: "Times New Roman", Times, serif;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0;
            margin: 0;
            color: #000;
            border-bottom: 3px solid #000;
        }
        .gradeTable{
            width: 100%;
            height: 130px !important;
            border: 1px solid #000;
            border-top-color: rgb(0, 0, 0);
            margin: 0;
            padding: 0;
            border-top: 0;
            border-spacing: 0;
            border-collapse: collapse;
        }
        .gradeTable tr th{
            font-weight: bold;
        }
        .gradeTable tr th, .gradeTable tr td{
            padding: 0;
            margin: 0;
            font-size: 8px;
            line-height: 8px;
            text-transform: uppercase;
            text-align: center;
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
        }
        .to3section{
            font-size: 12px;
            text-transform: uppercase;
            min-height: 112px;
            font-weight: bold;
        }
        .stInfo{
            width: 45%;
            float: left;

        }
        .clInfo{
            width: 30%;
            float: left;
        }
        .gInfo{
            width: 20%;
            float: right;
        }

        .clInfo table td, .stInfo table td{
            padding: 0;
            margin: 0;
            line-height: 2 top:0;
            bottom: 0;
        }
        .resmidcontainer {
            margin: 50px 0 0;
        }
        .hdrText {
            margin: -51px 0 0;
        }

    </style>

</head>

<body class="scms-result-print">
<button class="btn-print" onclick="printDiv('printableArea')">Print</button>
<div id="printableArea">
    <div class="wraperResult">
        <div class="resHdr">
            <img src="<?php echo url();?>/markssheetcontent/res-logo45.png" alt="" class="resLogo">            <div class="schoolIdentity">
                <img src="<?php echo url();?>/markssheetcontent/school-title45.png" alt="">
                <div class="hdrText">
                    <span><em>KNOWLEDGE IS POWER</em></span>
                    <span style="padding-top:10px;">{{$extra[0]}}INATION-{{$student->session}}</span>
<!--                    <span style="padding-top:10px;">{{$extra[0]}} EXAMINATION-{{$student->session}}</span>-->
                    <strong>{{$student->class}} / Equivalent Result Publication {{$student->session}} </strong>
                </div><!-- end of hdrText -->
            </div><!-- end of schoolIdentity -->
        </div><!-- end of resHdr -->

        <div class="resContainer">
            <div class="resTophdr">
                <div class="to3section stInfo">
                    <table>
                        <tr>
                            <td colspan="2">
                                <span style="font-size:14px;">{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                FATHER'S NAME
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->fatherName}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                MOTHER'S NAME
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->motherName}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                STUDENT ID
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->regiNo}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                DATE OF BIRTH
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->dob}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                BOARD
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: CHITTAGONG</span>
                            </td>
                        </tr>
                    </table>

                </div><!-- end of restopleft -->
                <div class="to3section clInfo">
                    <table>
                        <tr>
                            <td width="50%">
                                CLASS
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->class}}</span>
                            </td>
                        </tr>
                        <!--<tr>
                            <td width="50%">
                                GROUP
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->group}}</span>
                            </td>
                        </tr>-->
                        <tr>
                            <td width="50%">
                                SECTION
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->section}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                ROLL NO
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$student->rollNo}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                GPA
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$meritdata->point}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                GRADE
                            </td>
                            <td width="50%">
                                <span style="text-align: right;">: {{$meritdata->grade}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                              <span style="font-size: 10px;">Merit Possition</span>
                            </td>
                            <td width="50%">
                                <span style="text-align: right; text-transform: none;">:
                                    @if($meritdata->position==1)
                                        {{$meritdata->position}}st
                                    @elseif($meritdata->position==2)
                                        {{$meritdata->position}}nd
                                    @elseif($meritdata->position==3)
                                        {{$meritdata->position}}rd
                                    @else
                                        {{$meritdata->position}}th
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                 </div>
                <div class="gInfo">
                    <h2 class="gpaTile">GPA Grading</h2>
                    <table class="gradeTable">
                    <tbody><tr>
                    <th width="50%">Range of Marks(%)</th>
                    <th width="25%">Grade</th>
                    <th width="25%">Point</th>
                    </tr>
                    <tr>
                    <td>80 or Above </td>
                    <td>A+</td>
                    <td>5.00</td>
                    </tr>
                    <tr>
                    <td>70 to 79</td>
                    <td>A</td>
                    <td>4.00</td>
                    </tr>
                    <tr>
                    <td>60 to 69</td>
                    <td>A-</td>
                    <td>3.50</td>
                    </tr>
                    <tr>
                    <td>50 to 59</td>
                    <td>B</td>
                    <td>3.00</td>
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
                </div>
                <!-- end of restopleft -->
            </div>
            <!-- end of resTophdr -->


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
                <div class="achivement">


                    <h2 class="achievementTitle">Achievement</h2>
                    <table class="pagetble">
                        <tbody>
                        <tr>

                            <!--<th align="center" valign="middle">
                                <table class="childTable">
                                    <tr>
                                        <td>
                                            Merit Position
                                        </td>
                                    </tr>
                                    <tr><th align="center" valign="middle">@if($meritdata->position==1)
                                        {{$meritdata->position}}st
                                    @elseif($meritdata->position==2)
                                        {{$meritdata->position}}nd
                                    @elseif($meritdata->position==3)
                                        {{$meritdata->position}}rd
                                    @else
                                        {{$meritdata->position}}th
                                    @endif</th>

                                    </tr>
                                </table>
                            </th>-->
                            <th align="center" valign="middle">{{$extra[0]}}</th>
                            <th align="center" valign="middle">
                                @if($meritdata->grade!="F")
                                    @if($meritdata->point>=5.00)
                                        Excellent
                                    @elseif($meritdata->point>=4.00)
                                        Good
                                    @elseif($meritdata->point>="3.00")
                                        Average
                                    @elseif($meritdata->point>="2.00")
                                        Below Average
                                    @elseif($meritdata->point>="1.00")
                                        Poor
                                    @else
                                        Fail
                                    @endif
                                @else
                                    Fail
                                @endif

                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- end of overalreport -->
            </div><!-- end of resmidcontainer -->

            <!-- end of resmidcontainer -->
        </div><!-- end of resContainer -->
        <div class="signatureWraper"><div class="signatureCont">
                <div class="sign-grdn"><b>Signature (Guardian)</b></div>
                <div class="sign-clsT"><b>Signature (Class Teacher)</b></div>
                <div class="sign-head">
                <img src="<?php echo url();?>/markssheetcontent/head-sign.png" alt="" style="left:23px;bottom:21px">                <b>Signature (Head Master)</b>
                </div>
            </div></div><!-- end of signatureWraper -->
        <img src="<?php echo url();?>/markssheetcontent/certificate-bg45.png" alt="" class="result-bg">    </div><!-- end of wraperResult -->
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
