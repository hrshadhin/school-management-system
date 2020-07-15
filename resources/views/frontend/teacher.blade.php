@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_teachers') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_teachers')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_teachers')</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<main>
			<div class="container">
				<section class="clear-fix">
					<h2>@lang('site.meet_teacher')</h2>
					<div class="grid-col-row">
						@php $counter = 0; @endphp
						@foreach($profiles as $profile)

							@php
								++$counter;
                                if($counter>6) {
                                    $counter = 1;
                                }

							@endphp
							<div class="grid-col grid-col-6 @if($loop->iteration > 2) margin-top-20 @endif">
								<div class="item-instructor bg-color-{{$counter}}">
									<a href="#" class="instructor-avatar">
										<img src="@if($profile->image){{asset('storage/teacher_profile/'.$profile->image)}} @else {{ asset('images/avatar.jpg')}} @endif" alt>
									</a>
									<div class="info-box">
										<h3>{{$profile->name}}</h3>
										<span class="instructor-profession">{{$profile->designation}}</span>
										<div class="divider"></div>
										<p>{{$profile->description}}</p>
										<div class="social-link">
											<a target="_blank" href="@if($profile->facebook) {{$profile->facebook}} @else # @endif" class="fa fa-facebook"></a>
											<a target="_blank" href="@if($profile->instagram) {{$profile->instagram}} @else # @endif" class="fa fa-instagram"></a>
											<a target="_blank" href="@if($profile->twitter) {{$profile->twitter}} @else # @endif" class="fa fa-twitter"></a>
										</div>
									</div>
								</div>
							</div>
					@endforeach

				</section>
				<!-- pagination -->
				<div class="page-pagination clear-fix">

					<a title="prev"  @if($profiles->previousPageUrl()) href="{{$profiles->previousPageUrl()}}" @else href="#"  class="disabled" @endif>
						<i class="fa fa-angle-double-left"></i>
					</a>
					<a href="#" class="active">
						{{AppHelper::translateNumber($profiles->currentPage())}}
					</a>
					<a title="next" @if($profiles->nextPageUrl()) href="{{$profiles->nextPageUrl()}}" @else href="#"  class="disabled" @endif>
						<i class="fa fa-angle-double-right"></i>
					</a>


				</div>
				<!-- / pagination -->
			</div>
		</main>
	</div>
	<!-- / content -->

@endsection
