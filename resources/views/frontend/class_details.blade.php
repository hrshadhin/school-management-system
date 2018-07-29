@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.details') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.details')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="{{URL::route('site.class_profile')}}">@lang('site.menu_class')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.details')</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<div class="container clear-fix class-details">
			<div class="grid-col-row">
				<div class="grid-col grid-col-9">
					<!-- main content -->
					<main>
						<section>
							<h2>{{$profile->name}}</h2>
							<div class="picture">
								<div class="hover-effect"></div>
								<div class="link-cont">
									<a href="{{asset('storage/class_profile/'.$profile->image_lg)}}" class="fancy fa fa-search"></a>
								</div>
								<img src="{{asset('storage/class_profile/'.$profile->image_lg)}}"  alt>
							</div>
						</section>
					</main>
					<!-- / main content -->
				</div>
				<!-- sidebar -->
				<div class="grid-col grid-col-3 sidebar">
					<!-- widget -->
					<aside class="widget-course-details">
						<h2>@lang('site.information')</h2>
						<p>
							{{$profile->short_description}}
						</p>
					</aside>
					<!-- / widget -->
					<br>
					<!-- banner -->
					<div class="banner-offer icon-right bg-color-1">
						<div class="banner-icon">
							<i class="sms-icon-person"></i>
						</div>
						<div class="banner-text">
							<h4>@lang('site.teacher')</h4>
							<p>{{$profile->teacher}}</p>
						</div>
					</div>
					<!-- / banner -->
					<!-- banner -->
					<div class="banner-offer icon-right bg-color-2">
						<div class="banner-icon">
							<i class="fa fa-institution"></i>
						</div>
						<div class="banner-text">
							<h4>@lang('site.room_no')</h4>
							<p>{{$profile->room_no}}</p>
						</div>
					</div>
					<!-- / banner -->
					<!-- banner -->
					<div class="banner-offer icon-right bg-color-3">
						<div class="banner-icon">
							<i class="fa fa-users"></i>
						</div>
						<div class="banner-text">
							<h4>@lang('site.capacity')</h4>
							<p>{{$profile->capacity}}</p>
						</div>
					</div>
					<!-- / banner -->
					<!-- banner -->
					<div class="banner-offer icon-right bg-color-4">
						<div class="banner-icon">
							<i class="fa fa-clock-o"></i>
						</div>
						<div class="banner-text">
							<h4>@lang('site.description')</h4>
							<p>{{$profile->shift}}</p>
						</div>
					</div>
					<!-- / banner -->

				</div>
				<!-- / sidebar -->
			</div>
			<div class="grid-col-row">
				<div class="grid-col grid-col-12">
					<!-- main content -->
					<main>
						<section>
							<!-- tabs -->
							<div class="tabs">
								<div class="block-tabs-btn clear-fix">
									<div class="tabs-btn active" data-tabs-id="tabs1">@lang('site.description')</div>
									<div class="tabs-btn" data-tabs-id="tabs2">@lang('site.course_outline')</div>
								</div>
								<!-- tabs keeper -->
								<div class="tabs-keeper">
									<!-- tabs container -->
									<div class="container-tabs active" data-tabs-id="cont-tabs1">
										{!! $profile->description !!}
									</div>
									<!--/tabs container -->
									<!-- tabs container -->
									<div class="container-tabs" data-tabs-id="cont-tabs2">
										{!! $profile->outline !!}
									</div>
									<!--/tabs container -->
								</div>
								<!--/tabs keeper -->
							</div>
							<!-- /tabs -->

						</section>
					</main>
					<!-- / main content -->
				</div>
			</div>
		</div>
	</div>
	<!-- / content -->
@endsection
