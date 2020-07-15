<div class="report-header">
    <div class="row">
        <div class="col-xs-12">
            <div class="report-info">
                @if($showLogo && strlen($logo))
                    <table>
                        <tr>
                            <td style="text-align: left" width="40%">
                                <img src="{{asset('storage/logo/'.$logo)}}" alt="Logo">

                            </td>
                            <td style="text-align: left;" width="60%">
                                <h3 class="institute-name">{{$instituteName}}</h3>
                                <h5 class="institute-address">{{$instituteAddress}}</h5>
                                <h4 class="report-title">{{$reportTitle}}</h4>
                                <h5 class="report-subtitle">{!! $reportSubTitle !!}</h5>
                            </td>
                        </tr>
                    </table>
                @else
                <h3 class="institute-name">{{$instituteName}}</h3>
                <h5 class="institute-address">{{$instituteAddress}}</h5>
                <h4 class="report-title">{{$reportTitle}}</h4>
                <h5 class="report-subtitle">{!! $reportSubTitle !!}</h5>
                @endif
            </div>
            @if($showDate)<small class="print-date">Print Date: {{date('d/m/Y')}}</small>@endif
        </div>
    </div>
</div>
