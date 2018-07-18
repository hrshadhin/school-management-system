@extends('frontend.layouts.master')
@section('pageTitle') Contact Us @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>Contact Us</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">Home</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">Contact Us</a>
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
						<h2>Contact us</h2>
						<div class="widget-contact-form">
							<!-- contact-form -->
							<div class="info-boxes error-message alert-boxes error-alert" id="feedback-form-errors">
								<strong>Attention!</strong>
								<div class="message"></div>
							</div>
							<div class="email_server_responce"></div>
							<form action="{{URL::route('site.contact_us_form')}}" method="post" enctype="text/plain" class="supportForm alt clear-fix">
								@csrf
								<input type="text" name="name" value="" size="40" placeholder="Your Name" aria-invalid="false" aria-required="true">
								<input type="text" name="email" value="" size="40" placeholder="Your Email" aria-required="true">
								<input type="text" name="subject" value="" size="40" placeholder="Subject" aria-invalid="false" aria-required="true">
								<textarea name="message" cols="40" rows="3" placeholder="Your Message" aria-invalid="false" aria-required="true"></textarea>
								<button type="submit" class="cws-button border-radius alt">Send</button>
							</form>
							<!--/contact-form -->
						</div>
					</section>
				</div>
				<div class="grid-col grid-col-4 widget-address">
					<section>
						<h2>Our Office</h2>
						<address>
							<p>
								<strong class="fs-18">Address:</strong>
								<br/>{{$address->meta_value}}</p>
							<p>
								<strong class="fs-18">Phone number:</strong>
								<br/>
								<a href="tel:{{$phone->meta_value}}">{{$phone->meta_value}}</a>

							</p>
							<p>
								<strong class="fs-18">E-mail:</strong>
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
                '<h1 id="firstHeading" class="firstHeading">HR High School</h1>' +
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
                title: 'HR High School'
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

        }
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2XNtW7LbQh726PirpG7QH2Za2HVzrptk&callback=initMap">
	</script>

@endsection
