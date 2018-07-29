@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_contact_us') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_contact_us')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_contact_us')</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<!-- map -->
		<div class="container clear-fix">
			<div class="map wow fadeInUp">
				<div id="map" class="google-map"></div>
			</div>
		</div>
		<!-- / map -->
		<!-- contact form section -->
		<div class="grid-row clear-fix">
			<div class="grid-col-row">
				<div class="grid-col grid-col-8">
					<section>
						<h2>@lang('site.contact_us_form_title')</h2>
						<div class="widget-contact-form">
							<!-- contact-form -->
							<div class="info-boxes error-message alert-boxes error-alert" id="feedback-form-errors">
								<strong>Attention!</strong>
								<div class="message"></div>
							</div>
							<div class="email_server_responce"></div>
							<form action="{{URL::route('site.contact_us_form')}}" method="post" enctype="text/plain" class="supportForm alt clear-fix">
								@csrf
								<input type="text" name="name" value="" size="40" placeholder="@lang('site.yn')" aria-invalid="false" aria-required="true">
								<input type="text" name="email" value="" size="40" placeholder="@lang('site.ye')" aria-required="true">
								<input type="text" name="subject" value="" size="40" placeholder="@lang('site.subject')" aria-invalid="false" aria-required="true">
								<textarea name="message" cols="40" rows="3" placeholder="@lang('site.ym')" aria-invalid="false" aria-required="true"></textarea>
								<button type="submit" class="cws-button border-radius alt">@lang('site.send')</button>
							</form>
							<!--/contact-form -->
						</div>
					</section>
				</div>
				<div class="grid-col grid-col-4 widget-address">
					<section>
						<h2>@lang('site.our_office')</h2>
						<address>
							<p>
								<strong class="fs-18">@lang('site.address'):</strong>
								<br/>{{$address->meta_value}}</p>
							<p>
								<strong class="fs-18">@lang('site.phone_no'):</strong>
								<br/>
								<a href="tel:{{$phone->meta_value}}">{{$phone->meta_value}}</a>

							</p>
							<p>
								<strong class="fs-18">@lang('site.email'):</strong>
								<br/>
								<a href="mailto:{{$email->meta_value}}" class="email">
									<span class="">{{$email->meta_value}}</span>
								</a>
							</p>
						</address>
					</section>
				</div>
			</div>
		</div>
		<!-- / contact form section -->
	</div>
	<!-- / content -->
@endsection

@section('extraScript')
	<script>
        var marker;
        @php
		 $latLong = explode(',',$latlong->meta_value);
        @endphp
        function initMap() {
            var latLong = { lat: @if(isset($latLong[0])) {{$latLong[0]}} @else 23.7340076 @endif, lng: @if(isset($latLong[1])) {{$latLong[1]}} @else 90.3841824 @endif };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 19,
                center: latLong
            });

            var contentString = '<div id="content">' +
                '<div id="siteNotice">' +
                '</div>' +
                '<h1 id="firstHeading" class="firstHeading">{{$siteInfo["name"]}}</h1>' +
                '<div id="bodyContent">' +
                '<p>{{$address->meta_value}}</p>' +
                '</div>' +
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position: latLong,
                map: map,
                title: '{{$siteInfo["name"]}}'
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

        }
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2XNtW7LbQh726PirpG7QH2Za2HVzrptk&callback=initMap">
	</script>

@endsection
