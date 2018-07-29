@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_class') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_class')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_class')</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<div class="container">
			<!-- main content -->
			<main>
				<section>
					<div class="clear-fix">
						<div class="grid-col-row">
							@php $counter = 0; @endphp
							@foreach($profiles as $profile)

								@php
									++$counter;
									if($counter>6) {
										$counter = 1;
									}

								@endphp

								<div class="grid-col grid-col-4 @if($loop->iteration > 3) margin-top-20 @endif">
									<!-- course item -->
									<div class="course-item">
										<div class="course-hover">
											<img src="{{asset('storage/class_profile/'.$profile->image_sm)}}"  alt>
											<div class="hover-bg bg-color-{{$counter}}"></div>
											<a href="{{URL::route('site.class_details',$profile->slug)}}">@lang('site.details')</a>
										</div>
										<div class="course-name clear-fix">
											<span class="price">{{$profile->room_no}}</span>
											<h3>
												<a href="{{URL::route('site.class_details',$profile->slug)}}">{{$profile->name}}</a>
											</h3>
										</div>
										<div class="course-date bg-color-{{$counter}} clear-fix">
											<div class="day">
												<i class="fa fa-users"></i>{{$profile->capacity}}</div>
											<div class="time">
												<i class="fa fa-clock-o"></i>{{$profile->shift}}</div>
											<div class="divider"></div>
											<div class="description trim-text" >{{$profile->short_description}}</div>
										</div>
									</div>
									<!-- / course item -->
								</div>
							@endforeach

						</div>

					</div>
				</section>

			</main>
			<!-- / main content -->
		</div>
	</div>
	<!-- / content -->

@endsection
