<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{$headerData->reportFileName ?? $headerData->reportTitle }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Report CSS -->
    <link href="{{ asset(mix('/css/report.css')) }}" rel="stylesheet" type="text/css">
    <style>
        @if($text_color)
            *,
            *:before,
            *:after {
                color: {{$text_color}} !important;
            }
        @endif
        @if($background_color)
            html, body{
                 background-color: {{$background_color}} !important;
            }
        @endif
    </style>
    @yield("extraStyle")
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="report">
        <!-- report header -->
        @include('backend.report.layouts.header', ['reportTitle' => $headerData-> reportTitle,'reportSubTitle' => $headerData->reportSubTitle, 'showDate' => (isset($showDate) ? $showDate : true)])
        <!-- ./report header -->
        <!-- report body -->
        @yield('reportBody')
        <!-- /.report body -->
        <!-- report footer -->
{{--        @include('backend.report.layouts.footer')--}}
        <!-- /.report footer -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Extra js from child page -->
@yield("extraScript")
@if($printIt)
<script type="text/javascript">
    window.onload = function () {
        window.print();
        window.addEventListener("afterprint", function(event) {
            window.close();
        });

    };
</script>
@endif
</body>
</html>