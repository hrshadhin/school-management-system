@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_faq') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_faq')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_faq')</a>
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
							<h2>@lang('site.faq_title')</h2>
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
