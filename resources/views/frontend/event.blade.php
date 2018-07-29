@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_events') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_events')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_events')</a>
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
				<div class=" grid-col-row clear-fix">

					@foreach($events as $event)
					<div class="grid-col grid-col-4">
						<!-- blog post -->
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
										<a href="{{URL::route('site.event_details',$event->slug)}}" class="cws-left fancy fa fa-link"></a>
									</div>

									<img src="{{asset('storage/events/'.$event->cover_photo)}}"  class="columns-col-12" alt>

								</div>
								@endif
								@if($event->cover_video)
								<div class="video-player">
									{!! $event->cover_video !!}
								</div>
								@endif
								<h3>{{$event->title}}</h3>
								<p>
									{!! substr($event->description,0,80) !!}
									<a class="more" href="{{URL::route('site.event_details',$event->slug)}}">....<i class="fa fa-link"></i>@lang('site.more')</a>
								</p>
								@if($event->tags)
								<div class="tags-post">
									@foreach(explode(',', $event->tags) as $tag)
									<a href="#" rel="tag">{{$tag}}</a>
									@endforeach
								</div>
									@endif
							</article>
						</div>
						<!-- / blog post -->
					</div>
					@endforeach


				</div>

				<!-- pagination -->
				<div class="page-pagination clear-fix">

					<a title="prev"  @if($events->previousPageUrl()) href="{{$events->previousPageUrl()}}" @else href="#"  class="disabled" @endif>
						<i class="fa fa-angle-double-left"></i>
					</a>
					<a href="#" class="active">
						{{AppHelper::translateNumber($events->currentPage())}}
					</a>
					<a title="next" @if($events->nextPageUrl()) href="{{$events->nextPageUrl()}}" @else href="#"  class="disabled" @endif>
						<i class="fa fa-angle-double-right"></i>
					</a>


				</div>
				<!-- / pagination -->
			</main>
		</div>

	</div>
	<!-- / content -->

@endsection
