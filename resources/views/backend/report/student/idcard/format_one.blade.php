<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <title>Id Card</title>
    <style>
        body {
            font-family: 'Source Sans Pro', serif;
        }

        .row {
            width: 100%;
            overflow: hidden;
        }

        .card {
            border-radius: 10px;
            border: 2px solid #243F60;
            height: 323px;
            width: 204px;
            float: left;
            margin-right: 15px;
            margin-bottom: 30px;
            box-sizing: border-box;
            position: relative;
        }

        .blue {
            background-color: #DDE7F2;
        }

        .light_blue {
            background-color: #D0E2F3;
            border-color: #00206087;
        }


        .bold {
            font-weight: bold
        }

        .header {
            margin-top: 10px;
        }
        .footer {
            bottom: 0;
            position: absolute;
        }

        .header,
        .content,
        .footer,
        .signature,
        .barcode {
            width: 100%;
            overflow: hidden;
        }

        .barcode img {
            background-color: #fff;
        }

        .title {
            font-weight: bold;
            font-size: 14px;
        }

        .logo {
            height: 48px;
            width: 48px;
            float: left;
            margin-right: 5px;

        }

        .logo img {
            width: 100%;
            height: 100%;
        }

        .logo.krmdc-logo {
            height: 54px
        }

        .student_pic {
            width: 100%;
            display: block;
            overflow: hidden;
            text-align: center;
            box-sizing: border-box;
        }

        .student_pic img {
            width: 100%;
            max-width: 53px;
            margin: 0;
            box-sizing: border-box;
        }

        .signature {
            text-align: right;
        }

        .signature img {
            height: 28px;
            width: 101px;
            display: block;
        }

        .signature img,
        .signature span {
            float: right;
            margin-right: 5px;
        }

        .barcode img {
            width: 100%;
            background-color: #fff;
        }

        .barcode {
            text-align: center
        }

        table,
        span {
            font-size: 12px
        }

        table {
            padding-left: 5px
        }

        .footer span {
            width: 100%
        }

        .back {
            text-align: center;
        }

        .back h3 {
            padding: 0 15px;
            font-weight: normal
        }

        .back h2,
        .back h3 {
            font-size: 16px;
        }

        .back h2 {
            padding: 0 17px;
            margin-bottom: 6px;
        }

        .back span,
        .back a {
            display: block;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }

        .back-logo {
            width: 58px
        }

        .hrmghs {
            font-size: 15px
        }

        .border_blue {
            border: 2px solid #002060
        }

        back span,
        .back a {
            font-size: 14px;
        }

        .border_navy {
            border: 2px solid #3D49FC;
        }

        /*table{padding-left:2px}*/
        table td{line-height:1}
        td:first-child{width:50px}

        .txt_full {
            letter-spacing: 14px;
            text-align: center;
            padding-left: 5px;
            padding-right: 5px;
            overflow: hidden;
        }
        @media print{
            @page {
                size:  A4 landscape;
                margin-top: 10mm;
                margin-left: 0.10in;
                margin-right: 0;
                margin-bottom: 0;
            }

            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
                color-adjust: exact !important;                 /*Firefox*/
            }
        }
        @media print
        {
            div{
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body @if($templateConfig->body_text_color) style="color:{{$templateConfig->body_text_color}};"@endif>
<section class="main">
    <div class="row">
        <!-- hrmghs -->
        @if($side == "front" || $side=="both")
            @foreach($students as $student)
                <div class="card blue" style="@if($templateConfig->bg_color) background-color:{{$templateConfig->bg_color}}; @endif @if($templateConfig->border_color) border-color:{{$templateConfig->border_color}}; @endif">
                    <div class="header">
                        <div class="logo"><img src="data:image/png;base64,{{$templateConfig->logo}}"></div>
                        <div class="title hrmghs" @if($templateConfig->fs_title_color) style="color:{{$templateConfig->fs_title_color}};"@endif>{{strtoupper($instituteInfo['name'])}}</div>
                    </div>
                    <div class="content">
                        <span class="student_pic"><img class="border_navy" @if($templateConfig->picture_border_color) style="border-color:{{$templateConfig->picture_border_color}};"@endif src="@if($student->student->photo ){{ asset('storage/student')}}/{{ $student->class_id }}/{{ $student->student->photo }} @else {{ asset('images/avatar.jpg')}} @endif" /></span>
                        <table border="0" cellpadding="0" cellspaing="0">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{$student->student->name}}</td>
                            </tr>
                            <tr>
                                <td>Class</td>
                                <td>:</td>
                                <td>{{$student->class->name}}</td>
                            </tr>
                            <tr>
                                <td>Class Roll</td>
                                <td>:</td>
                                <td>{{$student->roll_no}}</td>
                            </tr>
                            <tr>
                                <td>Session</td>
                                <td>:</td>
                                <td>{{$session}}</td>
                            </tr>
                            <tr>
                                <td>Blood Group</td>
                                <td>:</td>
                                <td>{{$student->student->blood_group}}</td>
                            </tr>
                            <tr>
                                <td>Validity</td>
                                <td>:</td>
                                <td>{{$validity}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer">
                        <div class="signature">
                            <img src="data:image/png;base64,{{$templateConfig->signature}}" />
                            <span>Authorized Signature</span>
                        </div>
                        <div class="barcode">
                            <img src="{{AppHelper::getIdcardBarCode($student->regi_no)}}" />
                            <span class="txt_full">{{$student->regi_no}}</span>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @if($side =="back" || $side=="both")
            @for($count=0; $count < $totalStudent; $count++)
                <div class="card back blue" style="@if($templateConfig->bg_color) background-color:{{$templateConfig->bg_color}}; @endif @if($templateConfig->border_color) border-color:{{$templateConfig->border_color}}; @endif">
                    <h3>If Found Please Return The Card To</h3>
                    <img src="data:image/png;base64,{{$templateConfig->logo}}"
                         class="back-logo" />
                    <h2 @if($templateConfig->bs_title_color) style="color:{{$templateConfig->bs_title_color}};"@endif>{{strtoupper($instituteInfo['name'])}}</h2>
                    <span class="address">{{$instituteInfo['address']}} <br /> {{$instituteInfo['phone_no']}}</span>
                    <a href="#" @if($templateConfig->website_link_color) style="color:{{$templateConfig->website_link_color}};"@endif>{{$instituteInfo['website_link']}}</a>
                    <span>Email: {{$instituteInfo['email']}}</span>
                </div>
            @endfor
        @endif


    <!-- end hrmghs -->

    </div>
</section>
<script type="text/javascript">
    window.onload = function () {
        window.print();
        window.close();
    };
</script>
</body>

</html>