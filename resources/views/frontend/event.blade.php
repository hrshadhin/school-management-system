@extends('frontend.layouts.master')
@section('pageTitle') Events @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>Events</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">Home</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">Events</a>
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
					<div class="grid-col grid-col-4">
						<!-- blog post -->
						<div class="blog-post">
							<article>
								<div class="post-info event">
									<div class="date-post">
										<div class="time">10:30 AM</div>
									</div>
									<div class="post-info-main">
										<div class="event-info">
											26 Aug,2018
										</div>
									</div>

								</div>
								<div class="blog-media picture">
									<div class="hover-effect"></div>
									<div class="link-cont">
										<a href="event-details.html" class="cws-left fancy fa fa-link"></a>
										<a href="/frontend/uploads/events/370x270-img-5%402x.jpg" class="fancy fa fa-search"></a>
									</div>
									<img src="/frontend/uploads/events/370x270-img-5.jpg" data-at2x="/frontend/uploads/events/370x270-img-5@2x.jpg" class="columns-col-12"
										 alt>
								</div>
								<h3>Donec mollis magna quis</h3>
								<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at suscipit
									<a href="event-details.html">More</a>
								</p>
								<div class="tags-post">
									<a href="#" rel="tag">Materials</a>
									<!--
                                         -->
									<a href="#" rel="tag">Featured</a>
								</div>
							</article>
						</div>
						<!-- / blog post -->
					</div>

					<div class="grid-col grid-col-4">
						<!-- blog post -->
						<div class="blog-post">
							<article>
								<div class="post-info event">
									<div class="date-post">
										<div class="time">06:15 PM</div>
									</div>
									<div class="post-info-main">
										<div class="event-info">
											15 Jul,2018
										</div>
									</div>

								</div>
								<h3>Vestibulum volutpat est neque</h3>
								<p>Praesent ornare sollicitudin magna. Vestibulum volutpat est neque, in rutrum mi interdum
									quis. Praesent dictum rhoncus luctus.
									<a href="event-details.html">More</a>
								</p>
								<div class="tags-post">
									<a href="#" rel="tag">Arts</a>
									<!--
                                     -->
									<a href="#" rel="tag">Design</a>
								</div>
							</article>
						</div>
						<!-- /blog post -->
					</div>

					<div class="grid-col grid-col-4">
						<!-- blog post -->
						<div class="blog-post">
							<article>
								<div class="post-info event">
									<div class="date-post">
										<div class="time">03:30 PM</div>
									</div>
									<div class="post-info-main">
										<div class="event-info">
											26 Feb,2018
										</div>
									</div>

								</div>
								<div class="video-player">
									<iframe src="https://www.youtube.com/embed/PvoUgT1mlfA"></iframe>
								</div>
								<h3>Class aptent taciti sociosqu ad litora.</h3>
								<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at suscipit.
									Praesent sagittis magna nec neque viverra lobortis.
									<a href="event-details.html">More</a>
								</p>
								<div class="tags-post">
									<a href="#" rel="tag">Caltural</a>
									<!--
                                     -->
									<a href="#" rel="tag">Fun</a>
								</div>
							</article>
						</div>
						<!-- / blog post -->
					</div>
				</div>
				<div class=" grid-col-row clear-fix">
					<div class="grid-col grid-col-4">
						<!-- blog post -->
						<div class="blog-post">
							<article>
								<div class="post-info event">
									<div class="date-post">
										<div class="time">10:30 AM</div>
									</div>
									<div class="post-info-main">
										<div class="event-info">
											12 Feb,2018
										</div>
									</div>

								</div>
								<div class="blog-media picture">
									<div class="hover-effect"></div>
									<div class="link-cont">
										<a href="event-details.html" class="cws-left fancy fa fa-link"></a>
										<a href="/frontend/uploads/events/370x270-img-5%402x.jpg" class="fancy fa fa-search"></a>
									</div>
									<img src="/frontend/uploads/events/370x270-img-5.jpg" data-at2x="/frontend/uploads/events/370x270-img-5@2x.jpg" class="columns-col-12"
										 alt>
								</div>
								<h3>Donec mollis magna quis</h3>
								<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at suscipit
									<a href="event-details.html">More</a>
								</p>
								<div class="tags-post">
									<a href="#" rel="tag">Materials</a>
									<!--
                                             -->
									<a href="#" rel="tag">Featured</a>
								</div>
							</article>
						</div>
						<!-- / blog post -->
					</div>

					<div class="grid-col grid-col-4">
						<!-- blog post -->
						<div class="blog-post">
							<article>
								<div class="post-info event">
									<div class="date-post">
										<div class="time">04:00 PM</div>
									</div>
									<div class="post-info-main">
										<div class="event-info">
											15 Jan,2018
										</div>
									</div>

								</div>
								<div class="blog-media picture">
									<div class="hover-effect"></div>
									<div class="link-cont">
										<a href="event-details.html" class="cws-left fancy fa fa-link"></a>
										<a href="/frontend/uploads/events/370x270-img-5%402x.jpg" class="fancy fa fa-search"></a>
									</div>
									<img src="/frontend/uploads/events/370x270-img-5.jpg" data-at2x="/frontend/uploads/events/370x270-img-5@2x.jpg" class="columns-col-12"
										 alt>
								</div>
								<h3>Vestibulum volutpat est neque</h3>
								<p>Praesent ornare sollicitudin magna. Vestibulum volutpat est neque, in rutrum mi interdum
									quis. Praesent dictum rhoncus luctus.
									<a href="event-details.html">More</a>
								</p>
								<div class="tags-post">
									<a href="#" rel="tag">Arts</a>
									<!--
                                         -->
									<a href="#" rel="tag">Design</a>
								</div>
							</article>
						</div>
						<!-- /blog post -->
					</div>

					<div class="grid-col grid-col-4">
						<!-- blog post -->
						<div class="blog-post">
							<article>
								<div class="post-info event">
									<div class="date-post">
										<div class="time">07:30 AM</div>
									</div>
									<div class="post-info-main">
										<div class="event-info">
											16 Dec,2017
										</div>
									</div>

								</div>
								<div class="blog-media picture">
									<div class="hover-effect"></div>
									<div class="link-cont">
										<a href="event-details.html" class="cws-left fancy fa fa-link"></a>
										<a href="/frontend/uploads/events/370x270-img-5%402x.jpg" class="fancy fa fa-search"></a>
									</div>
									<img src="/frontend/uploads/events/370x270-img-5.jpg" data-at2x="/frontend/uploads/events/370x270-img-5@2x.jpg" class="columns-col-12"
										 alt>
								</div>
								<h3>Class aptent taciti sociosqu ad litora.</h3>
								<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at suscipit.
									Praesent sagittis magna nec neque viverra lobortis.
									<a href="event-details.html">More</a>
								</p>
								<div class="tags-post">
									<a href="#" rel="tag">Caltural</a>
									<!--
                                         -->
									<a href="#" rel="tag">Fun</a>
								</div>
							</article>
						</div>
						<!-- / blog post -->
					</div>
				</div>
				<!-- pagination -->
				<div class="page-pagination clear-fix">
					<a href="#">
						<i class="fa fa-angle-double-left"></i>
					</a>
					<!--
                            -->
					<a href="#" class="active">1</a>
					<!--
                            -->
					<a href="#">2</a>
					<!--
                            -->
					<a href="#">3</a>
					<!--
                            -->
					<a href="#">
						<i class="fa fa-angle-double-right"></i>
					</a>
				</div>
				<!-- / pagination -->
			</main>
		</div>

	</div>
	<!-- / content -->

@endsection
