@extends('frontend.layouts.master')

@section('pageTitle') @lang('site.menu_home') @endsection
@section('extraStyle')
	<link type="text/css" rel="stylesheet" href="{{ asset('/frontend/rs-plugin/css/settings.css') }}" />
@endsection

@section('pageContent')
	<!-- revolution slider -->
	<div class="tp-banner-container">
		<div class="tp-banner-slider">
			<ul>
				@foreach($sliders as $slider)
					@php
						$styleValue = 1;
						if($loop->iteration%3 == 0){
							$styleValue = 3;
						}
						else if($loop->iteration%2 == 0){
							$styleValue = 2;
						}
						else{
						  $styleValue = 1;
						}

					@endphp
					@if($styleValue == 1)
						<li data-masterspeed="700">
							<img src="/frontend/rs-plugin/assets/loader.gif" data-lazyload="{{asset('storage/sliders/'.$slider->image)}}" data-bgposition="left 20%"
								 alt>
							<div class="tp-caption sl-content align-left" data-x="['left','center','center','center']" data-hoffset="20" data-y="center"
								 data-voffset="0" data-width="['720px','600px','500px','300px']" data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;"
								 data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
								<div class="sl-title">{{$slider->title}}</div>
								<p>{{$slider->subtitle}}</p>
								<a href="#" class="cws-button border-radius">@lang('site.apply_now')
									<i class="fa fa-angle-double-right"></i>
								</a>
							</div>
						</li>
					@elseif($styleValue == 2)
						<li data-masterspeed="700">
							<img src="/frontend/rs-plugin/assets/loader.gif" data-lazyload="{{asset('storage/sliders/'.$slider->image)}}" alt>
							<div class="tp-caption sl-content align-right" data-x="['right','center','center','center']" data-hoffset="20" data-y="center"
								 data-voffset="0" data-width="['720px','600px','500px','300px']" data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;"
								 data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
								<div class="sl-title">{{$slider->title}}</div>
								<p>{{$slider->subtitle}}</p>
								<a href="#" class="cws-button border-radius">@lang('site.apply_now')
									<i class="fa fa-angle-double-right"></i>
								</a>
							</div>
						</li>

					@else
						<li data-masterspeed="700" data-transition="fade">
							<img src="/frontend/rs-plugin/assets/loader.gif" data-lazyload="{{asset('storage/sliders/'.$slider->image)}}" alt>
							<div class="tp-caption sl-content align-center" data-x="center" data-hoffset="0" data-y="center" data-voffset="0" data-width="['720px','600px','500px','300px']"
								 data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
								<div class="sl-title">{{$slider->title}}</div>
								<p>{{$slider->subtitle}}</p>
								<a href="#" class="cws-button border-radius">@lang('site.apply_now')
									<i class="fa fa-angle-double-right"></i>
								</a>
							</div>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
	<!-- / revolution slider -->
	<hr class="divider-color">
	<!-- content -->
	<div id="home" class="page-content padding-none">
		<section class="fullwidth-background padding-section">
			<div class="grid-row clear-fix">
				<h2 class="center-text">@lang('site.about_us')</h2>
				@if($aboutContent)
					<div class="grid-col-row">
						<div class="grid-col grid-col-6">
							<h3>@lang('site.why_we')</h3>
							<p>{{ $aboutContent->why_content }}</p>
							<!-- accordions -->
							<div class="accordions">
							@if($aboutContent->key_point_1_title)
								<!-- content-title -->
									<div class="content-title active">{{$aboutContent->key_point_1_title}}</div>
									<!--/content-title -->
									<!-- accordions content -->
									<div class="content">{!! $aboutContent->key_point_1_content !!}</div>
									<!--/accordions content -->
							@endif
							@if($aboutContent->key_point_2_title)
								<!-- content-title -->
									<div class="content-title">{{$aboutContent->key_point_2_title}}</div>
									<!--/content-title -->
									<!-- accordions content -->
									<div class="content">{!! $aboutContent->key_point_2_content !!}</div>
									<!--/accordions content -->
							@endif
							@if($aboutContent->key_point_3_title)
								<!-- content-title -->
									<div class="content-title">{{$aboutContent->key_point_3_title}}</div>
									<!--/content-title -->
									<!-- accordions content -->
									<div class="content">{!! $aboutContent->key_point_3_content !!}</div>
									<!--/accordions content -->
							@endif
							@if($aboutContent->key_point_4_title)
								<!-- content-title -->
									<div class="content-title">{{$aboutContent->key_point_4_title}}</div>
									<!--/content-title -->
									<!-- accordions content -->
									<div class="content">{!! $aboutContent->key_point_4_content !!}</div>
									<!--/accordions content -->
							@endif
							@if($aboutContent->key_point_5_title)
								<!-- content-title -->
									<div class="content-title">{{$aboutContent->key_point_5_title}}</div>
									<!--/content-title -->
									<!-- accordions content -->
									<div class="content">{!! $aboutContent->key_point_5_content !!}</div>
									<!--/accordions content -->
								@endif

							</div>
							<!--/accordions -->

						</div>
						<div class="grid-col grid-col-6">
							@if($aboutImages)
								<div class="owl-carousel full-width-slider">
									@foreach($aboutImages as $slider)
										<div class="gallery-item picture">
											<img src="{{asset('storage/about/'.$slider->image)}}"  alt>
										</div>
									@endforeach

								</div>
							@else
								<div class="alert alert-warning">
									<span>@lang('site.empty_content')</span>
								</div>
							@endif
						</div>
					</div>
				@else
					<div class="alert alert-warning">
						<span>@lang('site.empty_content')</span>
					</div>
				@endif
			</div>
		</section>

		<hr class="divider-color" />
	@if($aboutContent && $aboutContent->intro_video_embed_code)
		<!-- section -->
			<section class="padding-section">
				<div class="grid-row clear-fix">
					<div class="grid-col-row">
						<div class="grid-col grid-col-6">
							<div class="video-player">
								{!! $aboutContent->intro_video_embed_code !!}
							</div>
						</div>
						<div class="grid-col grid-col-6 clear-fix">
							<h2>@lang('site.about_us_more')</h2>
							<p>
								{{ $aboutContent->who_we_are }}
							</p>
							@if($aboutContent->video_site_link)
								<br/>
								<br/>
								<br/>
								<br/>
								<a href="{{$aboutContent->video_site_link}}" class="cws-button bt-color-3 border-radius alt icon-right float-right">@lang('site.about_us_more2')
									<i class="fa fa-angle-right"></i>
								</a>
							@endif
						</div>
					</div>
				</div>
			</section>
			<!-- / section -->
			<hr class="divider-color" />
	@endif
		<!-- section -->
		<section class="fullwidth-background padding-section">
			<div class="grid-row clear-fix">
				<div class="grid-col-row">
					<div class="grid-col grid-col-6">
						<a href="#0" title="Education" class="service-icon">
							<i class="flaticon-graduate"></i>
						</a>
						<a href="#0" title="Medical Facility" class="service-icon">
							<i class="flaticon-medical"></i>
						</a>
						<a href="#0" title="Canteen" class="service-icon">
							<i class="flaticon-restaurant"></i>
						</a>
						<a href="#0" title="Arts & Drawing" class="service-icon">
							<i class="flaticon-website"></i>
						</a>
						<a href="#0" title="Transport" class="service-icon">
							<i class="sms-icon-bus"></i>
						</a>
						<a href="#0" title="Hostel" class="service-icon">
							<i class="flaticon-hotel"></i>
						</a>
						<a href="#0" title="Computer Lab" class="service-icon">
							<i class="flaticon-computer"></i>
						</a>
						<a href="#0" title="Library" class="service-icon">
							<i class="flaticon-book1"></i>
						</a>

					</div>
					<div class="grid-col grid-col-6 clear-fix">
						<h2>@lang('site.service')</h2>
						@if($ourService)
						<p>{{$ourService->meta_value}}</p>
							@else
						<p>@lang('site.empty_content')</p>
							@endif

					</div>
				</div>
			</div>
		</section>
		<hr class="divider-color" />

		<div class="parallaxed">
			<div class="parallax-image" data-parallax-left="0.5" data-parallax-top="0.3" data-parallax-scroll-speed="0.5">
				<img src="/frontend/img/parallax.png" alt="">

			</div>
			<div class="them-mask bg-color-1"></div>
			<div class="grid-row">
				<div class="grid-col-row clear-fix statistic">
					@if($statistic)
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="flaticon-multiple"></i>
							<div class="counter" data-count="{{$statistic->student}}">0</div>
							<div class="counter-name">@lang('site.stat_students')</div>
						</div>
					</div>
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="sms-icon-group"></i>
							<div class="counter" data-count="{{$statistic->teacher}}">0</div>
							<div class="counter-name">@lang('site.stat_teachers')
							</div>
						</div>
					</div>
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="flaticon-college"></i>
							<div class="counter" data-count="{{$statistic->graduate}}">0</div>
							<div class="counter-name">@lang('site.stat_college')</div>
						</div>
					</div>
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="flaticon-book1 last"></i>
							<div class="counter" data-count="{{$statistic->books}}">0</div>
							<div class="counter-name">@lang('site.stat_books')</div>
						</div>
					</div>
						@else
						<div class="grid-col grid-col-3 alt">
							<p>@lang('site.empty_content')</p>
						</div>
						@endif
				</div>
			</div>
		</div>
		<!-- / paralax section -->

		<hr class="divider-color" />
		<!-- / section -->
		<section class="fullwidth-background testimonial padding-section">
			<div class="grid-row">
				<h2 class="center-text">@lang('site.testimonials')</h2>
				<div class="owl-carousel testimonials-carousel">
					@foreach($testimonials as $test)
					<div class="gallery-item">
						<div class="quote-avatar-author clear-fix">
							<img src="@if($test->photo ){{ asset('storage/testimonials')}}/{{ $test->photo }} @else {{ asset('images/avatar.jpg')}} @endif" alt="">
							<div class="author-info">{{$test->writer}}</div>
						</div>
						<p>{{$test->comments}}</p>
					</div>
						@endforeach

				</div>
			</div>
		</section>

		<!-- / paralax section -->
		<hr class="divider-color" />
		<!-- paralax section -->

		<!-- paralax section -->
		<!-- parallax section -->
		<div class="parallaxed">
			<div class="parallax-image" data-parallax-left="0.5" data-parallax-top="0.3" data-parallax-scroll-speed="0.5">
				<img src="{{asset('frontend/img/parallax.png')}}" alt="">
			</div>
			<div class="them-mask bg-color-4"></div>
			<div class="grid-row center-text">
				<div class="font-style-1 margin-none">@lang('site.get_in')</div>
				<div class="divider-mini"></div>
				<p class="parallax-text">@lang('site.drop_email')</p>
				<form id="subscribeFrom" class="subscribe" action="{{URL::route('site.subscribe')}}" method="POST" enctype="multipart/form-data" >
					@csrf
					<input type="email" name="email" size="40" required placeholder="@lang('site.write_email')" aria-required="true">
					<input type="submit" value="@lang('site.subscribe')">
				</form>
			</div>
		</div>
		<!-- parallax section -->
	</div>
	<!-- / content -->

@endsection

@section('extraScript')
	<script src="{{ asset('/frontend/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
	<script src="{{ asset('/frontend/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
@endsection


