@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_gallery') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_gallery')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_gallery')</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<div class="grid-row">
			<main>
				<div class="isotope-container">
					<div class="isotope-header clear-fix">
						<h2 class="margin-none">@lang('site.gallery_title')</h2>
						{{--<div class="select-wrapper">--}}
							{{--<select class="filter">--}}
								{{--<option value="*" selected>All</option>--}}
								{{--<option value=".classrooms">Classrooms</option>--}}
								{{--<option value=".students">Students</option>--}}
								{{--<option value=".library">Library</option>--}}
								{{--<option value=".teachers">Teachers</option>--}}
							{{--</select>--}}
						{{--</div>--}}

					</div>
					<div class="grid-col-row">
						<div class="isotope">
							@foreach($images as $image)
							<div class="item">
								<div class="picture">
									<div class="hover-effect"></div>
									<div class="link-cont">
										<a href="{{asset('storage/gallery/'.$image->meta_value)}}" class="fancy fa fa-search"></a>
									</div>
									<img style="min-height: 300px;" src="{{asset('storage/gallery/'.$image->meta_value)}}" alt>
								</div>
							</div>
							@endforeach

						</div>
					</div>
					<!-- pagination -->
					<div class="page-pagination clear-fix">

						<a title="prev"  @if($images->previousPageUrl()) href="{{$images->previousPageUrl()}}" @else href="#"  class="disabled" @endif>
							<i class="fa fa-angle-double-left"></i>
						</a>
						<a href="#" class="active">
							{{AppHelper::translateNumber($images->currentPage())}}
						</a>
						<a title="next" @if($images->nextPageUrl()) href="{{$images->nextPageUrl()}}" @else href="#"  class="disabled" @endif>
							<i class="fa fa-angle-double-right"></i>
						</a>


					</div>
					<!-- / pagination -->

				</div>
			</main>
		</div>
	</div>
	<!-- / content -->
@endsection
