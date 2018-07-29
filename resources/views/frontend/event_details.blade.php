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
				<a href="{{URL::route('site.event')}}">@lang('site.menu_events')</a>
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
		<div class="container clear-fix">
			<div class="grid-col-row">
				<main>
					<div class="blog-post">
						<article>
							<div class="post-info event">
								<div class="date-post">
									<div class="time">{{$event->event_time->format('h:i a')}}</div>
								</div>
								<div class="post-info-main">
									<div class="event-info">
										{{$event->event_time->format('d M,Y')}}
									</div>
								</div>

							</div>
							@if($event->cover_photo)
								<div class="blog-media picture">
									<div class="hover-effect"></div>
									<div class="link-cont">
										<a href="{{asset('storage/events/'.$event->cover_photo)}}" class="fancy fa fa-search"></a>
									</div>
									<img style="max-height: 450px;" src="{{asset('storage/events/'.$event->cover_photo)}}"  class="columns-col-12" alt>

								</div>
							@endif
							@if($event->cover_video)
								<div class="video-player">
									{!! $event->cover_video !!}
								</div>
							@endif

							<h2>{{$event->title}}</h2>
							{!! $event->description !!}
							<!--  gallery slider -->
							<div class="owl-carousel full-width-slider">
								@if($event->slider_1)
								<div class="gallery-item picture">
									<img src="{{asset('storage/events/'.$event->slider_1)}}" alt>
								</div>
								@endif
									@if($event->slider_2)
								<div class="gallery-item picture">
									<img src="{{asset('storage/events/'.$event->slider_2)}}" alt>
								</div>
								@endif
									@if($event->slider_3)
								<div class="gallery-item picture">
									<img src="{{asset('storage/events/'.$event->slider_3)}}" alt>
								</div>
								@endif
							</div>
							<!-- /  gallery slider -->
							<br>
							@if($event->tags)
							<div class="tags-post">
								@foreach(explode(',', $event->tags) as $tag)
									<a href="#" rel="tag">{{$tag}}</a>
								@endforeach

							</div>
								@endif
						</article>
					</div>
				</main>
			</div>
		</div>
	</div>
	<!-- / content -->
@endsection
