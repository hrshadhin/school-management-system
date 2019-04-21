@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_contact_us') @endsection

@section('extraStyle')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
		  crossorigin="" />
@endsection

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
	<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q=="
			crossorigin=""></script>
	<script>
        @php
		 $latLong = explode(',',$latlong->meta_value);
        @endphp
        var map = L.map('map').setView([@if(isset($latLong[0])) {{$latLong[0]}} @else 23.7340076 @endif, @if(isset($latLong[1])) {{$latLong[1]}} @else 90.3841824 @endif], 19);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var contentString = '<b>{{$siteInfo["name"]}}</b><br><span>{{$address->meta_value}}</span>';
        L.marker([@if(isset($latLong[0])) {{$latLong[0]}} @else 23.7340076 @endif, @if(isset($latLong[1])) {{$latLong[1]}} @else 90.3841824 @endif]).addTo(map)
            .bindPopup(contentString)
            .openPopup();
	</script>

@endsection
