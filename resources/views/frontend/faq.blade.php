@extends('frontend.layouts.master')
@section('pageTitle') FAQ @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>FAQ</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">Home</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">FAQ</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<div class="grid-row clear-fix">
			<div class="grid-col-row">
				<main>
					<div class="grid-col grid-col-12">
						<section class="padding-top-none">
							<h2>Frequently asked question</h2>
							<!-- accordions -->
							<div class="accordions">
							@foreach($faqs as $faq)
								@php
									$qa = json_decode($faq->meta_value);
								@endphp
								<!-- content-title -->
								<div class="content-title @if($loop->iteration == 1)active @endif">{{$qa->q}}</div>
								<!--/content-title -->
								<!-- accordions content -->
								<div class="content">
									{!! $qa->a !!}
								</div>
								<!--/accordions content -->
								@endforeach
							</div>
							<!-- accordions -->
						</section>
					</div>
				</main>

			</div>
		</div>
	</div>
	<!-- / content -->
@endsection
