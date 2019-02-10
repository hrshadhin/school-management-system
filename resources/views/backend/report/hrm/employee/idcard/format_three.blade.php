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

        .header,
        .content,
        .footer,
        .signature,
        .barcode {
            width: 100%;
            overflow: hidden;
        }

        .footer {
            bottom: 0;
            position: absolute;
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
            margin: 4px auto;
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

        .border_blue {
            border: 2px solid #002060
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


        .hrbc .back h3 {
            font-size: 15px
        }

        .hrbc .barcode {
            bottom: 0;
            position: absolute;
        }

        .hrbc.back span,
        .back a {
            font-size: 14px
        }

        .hrbc.back a,
        .hrbc.back h2 {
            color: #002060
        }

        .hrbc .title {
            background-color: #002060;
            color: #fff;
            font-size: 15px;
            text-align: right;
            width: 100%;
            padding: 5px 0;
            box-sizing: border-box;
            padding-right: 5px;

        }

        .hrbc {
            position: relative
        }

        .hrbc .logo {
            position: absolute;
            z-index: 2;
            top: 0;
            left: 4px
        }

        .id_title {
            display: block;
            overflow: hidden;
            color: #fff;
            text-align: center;
            padding: 3px 45px 3px 12px;
            position: absolute;
            z-index: 2;
            top: 5px;
            right: 0
        }

        .hrbc .txt_full {
            letter-spacing: 13.5px;
            font-weight: normal;
            padding-left: 5px;
        }

        .hrbc .content {
            position: relative;
        }

        .id_bg {
            width: 100%;
            margin-top: 5px;
        }

        .hrbc .student_pic {
            margin-top: -38px;
        }

        .hrbc.back h3 {
            margin-top: 10px;
            margin-bottom: 2px;
        }

        .hrbc.back h2 {
            margin-bottom: 5px;
            margin-top: 5px;
        }
        /*table{padding-left:2px}*/
        table td{line-height:1}
        .hrbc tr td:first-child{width:54px}
        .hrbc .student_pic img{margin:4px auto}

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
        <!-- khalil mir college-->
        @if($side == "front" || $side=="both")
            @foreach($employees as $employee)
        <div class="card light_blue hrbc" style="@if($templateConfig->bg_color) background-color:{{$templateConfig->bg_color}}; @endif @if($templateConfig->border_color) border-color:{{$templateConfig->border_color}}; @endif">
            <div class="logo"><img src="data:image/png;base64,{{$templateConfig->logo}}"></div>
            <div class="header">
                <div class="title"  style="@if($templateConfig->fs_title_color) color:{{$templateConfig->fs_title_color}};@endif @if($templateConfig->fs_title_bg_color) background-color:{{$templateConfig->fs_title_bg_color}};@endif">{{strtoupper($instituteInfo['name'])}}</div>
            </div>
            <div class="content">
                @if($templateConfig->title_bg_image)
                    <img class="id_bg" src="data:image/png;base64,{{$templateConfig->title_bg_image}}" />
                    @else
                <img class="id_bg" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAABcCAYAAAAf82z+AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo0MzcxOTcwYS1jNGRhLTkxNDUtOWEzZi0xNGY2Y2YzZWJjY2QiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QzJFQTQ4RTExQjFEMTFFOTgxOTNBQkYyNjdCRTVEQ0MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QzJFQTQ4RTAxQjFEMTFFOTgxOTNBQkYyNjdCRTVEQ0MiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzNzE5NzBhLWM0ZGEtOTE0NS05YTNmLTE0ZjZjZjNlYmNjZCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo0MzcxOTcwYS1jNGRhLTkxNDUtOWEzZi0xNGY2Y2YzZWJjY2QiLz4gPC9y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">
                @endif
                <span class="id_title" @if($templateConfig->id_title_color) style="color:{{$templateConfig->id_title_color}};"@endif>Employee ID CARD</span>
                <span class="student_pic">
                        <img class="border_blue" @if($templateConfig->picture_border_color) style="border-color:{{$templateConfig->picture_border_color}};"@endif src="@if($employee->photo){{ asset('storage/employee')}}/{{ $employee->photo }} @else {{ asset('images/avatar.jpg')}} @endif" />
                    </span>
                <table border="0" cellpadding="0" cellspaing="0">
                    <tr>
                        <td class="bold">Name</td>
                        <td class="bold">:</td>
                        <td>{{$employee->name}}</td>
                    </tr>
                    <tr>
                    <tr>
                        <td class="bold">Designation</td>
                        <td class="bold">:</td>
                        <td>{{$employee->designation}}</td>
                    </tr>
                    <tr>
                        <td class="bold">Phone No.</td>
                        <td class="bold">:</td>
                        <td>{{$employee->phone_no}}</td>
                    </tr>
                    <tr>
                        <td class="bold">Religion</td>
                        <td class="bold">:</td>
                        <td>{{$employee->religion}}</td>
                    </tr>
                    <tr>
                        <td class="bold">Shift</td>
                        <td class="bold">:</td>
                        <td>{{$employee->shift}}</td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <div class="signature">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHcAAAAhBAMAAAARwClTAAAAMFBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABaPxwLAAAAAXRSTlMAQObYZgAAAV5JREFUOMulVFFugzAMNZ1WqRLCaBdYb7DegCtwg/ZIvUGvshvsCrvBDKh/lTzHToGyJVBiIQix34vzHAdgbNkR1ljVuTfWzyORuQQkgCIU8UohD5unidEHsXPkYkRRbP99Box+Oq5zAMwzmzLvm7xyVhvTdPFC5Bp7ZO5iWw5XkbnGIuRdchAowv3o2/0j2N9k71MXwfeuYjSGzHi/xtgX9d9GfB8uCo3RRmw/PKhKfjnmaTI7tngEA2uDDRy2cdv7XqYRp6KQxrkINi95QvIHRQcbx/nzKBMedElyOQiSJGIj4e8OVupeCSpPb5w05G75dgS1IeVpJBncQ6ViUEZQSkTpXHlnCvFQDYJv4DPgFbZC37BKw3xXsb0CnlvTBw94cqi2L54vkiw2te1n4BLQMtOC5l10KUECmBLAONtpEZO2qBKynrsg4mBKyHo9GFPB6ytFKfiUMyLdtDj0F4hoo+2pfCyPAAAAAElFTkSuQmCC" />
                    <span>Authorized Signature</span>
                </div>

            </div>

        </div>
            @endforeach
        @endif
        @if($side =="back" || $side=="both")
            @foreach($employees as $employee)
        <div class="card back light_blue hrbc" style="@if($templateConfig->bg_color) background-color:{{$templateConfig->bg_color}}; @endif @if($templateConfig->border_color) border-color:{{$templateConfig->border_color}}; @endif">
            <h3 class="bold">If Found Please Return the Card To</h3>
            <img src="data:image/png;base64,{{$templateConfig->logo}}" class="back-logo" />
            <h2 @if($templateConfig->bs_title_color) style="color:{{$templateConfig->bs_title_color}};"@endif>{{strtoupper($instituteInfo['name'])}}</h2>
            <span class="address">{{$instituteInfo['address']}} <br /> {{$instituteInfo['phone_no']}}</span>
            <a href="#" @if($templateConfig->website_link_color) style="color:{{$templateConfig->website_link_color}};"@endif>{{$instituteInfo['website_link']}}</a>
            <span>Email: {{$instituteInfo['email']}}</span>
            <div class="barcode">
                <img src="{{AppHelper::getIdcardBarCode($employee->id_card)}}" />
                <span class="txt_full">{{$employee->id_card}}</span>
            </div>
        </div>
        @endforeach
    @endif
        <!--end hrbc-->
    </div>
</section>
<script type="text/javascript">
    window.onload = function () {
        window.print();
        // window.close();
    };
</script>
</body>

</html>