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
        }

        .yellow {
            background-color: #E4CFBE;
            border-color: #FABF8F
        }

        .bold {
            font-weight: bold
        }

        .header {
            margin-top: 11px;
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

        .logo.hrmdc-logo {
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
        }

        .barcode {
            text-align: center
        }

        table,
        span {
            font-size: 12px
        }

        table {
            padding-left: 5px;
            margin-top: 10px;
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

        .border_red {
            border: 2px solid #E36C0A
        }

        back span,
        .back a {
            font-size: 14px;
        }

        .txt_full {
            letter-spacing: 14px;
            text-align: center;
            padding-left: 5px;
            padding-right: 5px;
            overflow: hidden;
        }

        .hrmdc {
            position: relative
        }

        .hrmdc .header {
            margin-top: 4px
        }

        .hrmdc .title {
            text-align: center;
            color: #244061
        }

        .hrmdc .logo img {
            border-radius: 5px;
        }

        .hrmdc .footer {
            position: absolute;
            z-index: 2;
            bottom: 5px;
        }

        .hrmdc.back h2 {
            font-size: 15px;
            padding: 0 7px;
        }

        .hrmdc .signature img {
            max-width: 70px;
        }

        .hrmdc .bold {
            font-weight: bold
        }

        .hrmdc .barcode span {
            background: #fff;
            width: 100%;
            display: block;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            letter-spacing: 13px;
            text-align: center;
            padding-left: 8px;
            padding-right: 5px;
            overflow: hidden;
            box-sizing: border-box;
        }

        .hrmdc .barcode {
            max-width: 194px;
            margin: 0 auto;
        }

        .hrmdc a {
            color: #0563C1
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
        <!-- mohila degree college-->
        @if($side == "front" || $side=="both")
            @foreach($employees as $employee)
                <div class="card yellow hrmdc" style="@if($templateConfig->bg_color) background-color:{{$templateConfig->bg_color}}; @endif @if($templateConfig->border_color) border-color:{{$templateConfig->border_color}}; @endif">
                    <div class="header">
                        <div class="logo hrmdc-logo">
                            <img src="data:image/png;base64,{{$templateConfig->logo}}">
                        </div>
                        <div class="title hrmghs" @if($templateConfig->fs_title_color) style="color:{{$templateConfig->fs_title_color}};"@endif>{{strtoupper($instituteInfo['name'])}}</div>
                    </div>
                    <div class="content">
                    <span class="student_pic">
                        <img class="border_red" @if($templateConfig->picture_border_color) style="border-color:{{$templateConfig->picture_border_color}};"@endif src="@if($employee->photo){{ asset('storage/employee')}}/{{ $employee->photo }} @else {{ asset('images/avatar.jpg')}} @endif" />
                    </span>
                        <table border="0" cellpadding="0" cellspaing="0">
                            <tr>
                                <td style="font-size: 10px;" class="bold">Name</td>
                                <td>:</td>
                                <td style="font-size: 10px;" class="bold">{{$employee->name}}</td>
                            </tr>
                            <tr>
                                <td>Designation</td>
                                <td>:</td>
                                <td>{{$employee->designation}}</td>
                            </tr>
                            <tr>
                                <td>Phone No.</td>
                                <td>:</td>
                                <td>{{$employee->phone_no}}</td>
                            </tr>
                            <tr>
                                <td>Religion</td>
                                <td>:</td>
                                <td>{{$employee->religion}}</td>
                            </tr>
                            <tr>
                                <td>Shift</td>
                                <td>:</td>
                                <td>{{$employee->shift}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer">
                        <div class="signature">
                            <img src="data:image/png;base64,{{$templateConfig->signature}}" />
                            <span>Authorized Signature</span>
                        </div>
                        <div class="barcode">
                            <img src="{{AppHelper::getIdcardBarCode($employee->id_card)}}" />
                            <span clas="txt_full">{{$employee->id_card}}</span>
                        </div>
                    </div>

                </div>
            @endforeach
        @endif
        @if($side =="back" || $side=="both")
            @for($count=0; $count < count($employees); $count++)
                <div class="card back yellow hrmdc" style="@if($templateConfig->bg_color) background-color:{{$templateConfig->bg_color}}; @endif @if($templateConfig->border_color) border-color:{{$templateConfig->border_color}}; @endif">
                    <h3 class="bold">If Found Please Return the Card To</h3>
                    <img src="data:image/png;base64,{{$templateConfig->logo}}" class="back-logo" />
                    <h2 @if($templateConfig->bs_title_color) style="color:{{$templateConfig->bs_title_color}};"@endif>{{strtoupper($instituteInfo['name'])}}</h2>
                    <span class="address">{{$instituteInfo['address']}} <br /> {{$instituteInfo['phone_no']}}</span>
                    <a href="#" @if($templateConfig->website_link_color) style="color:{{$templateConfig->website_link_color}};"@endif>{{$instituteInfo['website_link']}}</a>
                    <span>Email: {{$instituteInfo['email']}}</span>
                </div>
        @endfor
    @endif
    <!--end mohila degree-->


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