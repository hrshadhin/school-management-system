@extends('frontend.layouts.master')

@section('extraStyle')
    <link type="text/css" rel="stylesheet" href="{{ asset('/frontend/rs-plugin/css/settings.css') }}" />
@endsection

@section('pageContent')
	<!-- revolution slider -->
	<div class="tp-banner-container">
		<div class="tp-banner-slider">
			<ul>
				<li data-masterspeed="700">
					<img src="/frontend/rs-plugin/assets/loader.gif" data-lazyload="/frontend/uploads/slider/slider-1.jpg" data-bgposition="left 20%"
					 alt>
					<div class="tp-caption sl-content align-left" data-x="['left','center','center','center']" data-hoffset="20" data-y="center"
					 data-voffset="0" data-width="['720px','600px','500px','300px']" data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;"
					 data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
						<div class="sl-title">Get Everything Right</div>
						<p>Aenean viverra lobortis purus, sed eleifend nisl egestas in
							<br/>Proin lacus augue, ornare quis nunc vel</p>
						<a href="admission.html" class="cws-button border-radius">Apply Now
							<i class="fa fa-angle-double-right"></i>
						</a>
					</div>
				</li>
				<li data-masterspeed="700">
					<img src="/frontend/rs-plugin/assets/loader.gif" data-lazyload="/frontend/uploads/slider/slider-2.jpg" alt>
					<div class="tp-caption sl-content align-right" data-x="['right','center','center','center']" data-hoffset="20" data-y="center"
					 data-voffset="0" data-width="['720px','600px','500px','300px']" data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;"
					 data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
						<div class="sl-title">Forward. Thinking.</div>
						<p>Aenean viverra lobortis purus, sed eleifend nisl egestas in
							<br/>Proin lacus augue, ornare quis nunc vel</p>
						<a href="admission.html" class="cws-button border-radius">Apply Now
							<i class="fa fa-angle-double-right"></i>
						</a>
					</div>
				</li>
				<li data-masterspeed="700" data-transition="fade">
					<img src="/frontend/rs-plugin/assets/loader.gif" data-lazyload="/frontend/uploads/slider/slider-3.jpg" alt>
					<div class="tp-caption sl-content align-center" data-x="center" data-hoffset="0" data-y="center" data-voffset="0" data-width="['720px','600px','500px','300px']"
					 data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
						<div class="sl-title">Knowledge for life</div>
						<p>Aenean viverra lobortis purus, sed eleifend nisl egestas in
							<br/>Proin lacus augue, ornare quis nunc vel</p>
						<a href="admission.html" class="cws-button border-radius">Apply Now
							<i class="fa fa-angle-double-right"></i>
						</a>
					</div>
				</li>
				<li data-masterspeed="700" data-transition="fade">
					<img src="/frontend/rs-plugin/assets/loader.gif" data-bgposition="center right" data-lazyload="/frontend/uploads/slider/slider-4.jpg"
					 alt>
					<div class="tp-caption sl-content align-left" data-x="['left','center','center','center']" data-hoffset="20" data-y="center"
					 data-voffset="40" data-width="['720px','600px','500px','300px']" data-transform_in="opacity:0;s:1000;e:Power2.easeInOut;"
					 data-transform_out="opacity:0;s:300;s:1000;" data-start="400">
						<div class="sl-title">Your revolution starts</div>
						<p>Aenean viverra lobortis purus, sed eleifend nisl egestas in
							<br/>Proin lacus augue, ornare quis nunc vel</p>
						<a href="admission.html" class="cws-button border-radius">Apply Now
							<i class="fa fa-angle-double-right"></i>
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- / revolution slider -->
	<hr class="divider-color">
	<!-- content -->
	<div id="home" class="page-content padding-none">
		<section class="fullwidth-background padding-section">
			<div class="grid-row clear-fix">
				<h2 class="center-text">About Us</h2>
				<div class="grid-col-row">
					<div class="grid-col grid-col-6">
						<h3>Why We Are Better</h3>
						<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at suscipit. Vivamus orci urna, ornare
							vitae tellus in.</p>
						<!-- accordions -->
						<div class="accordions">
							<!-- content-title -->
							<div class="content-title active">Donec sollicitudin lacus?</div>
							<!--/content-title -->
							<!-- accordions content -->
							<div class="content">Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.</div>
							<!--/accordions content -->
							<!-- content-title -->
							<div class="content-title">Lorem ipsum dolor sit amet?</div>
							<!--/content-title -->
							<!-- accordions content -->
							<div class="content">Nullam elementum tristique risus nec pellentesque. Pellentesque bibendum nunc eget nunc hendrerit auctor. Cum sociis
								natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur gravida urna nisl</div>
							<!--/accordions content -->
							<!-- content-title -->
							<div class="content-title">Aenean commodo ligula eget dolor?</div>
							<!--/content-title -->
							<!-- accordions content -->
							<div class="content">Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.</div>
							<!--/accordions content -->
							<!-- content-title -->
							<div class="content-title">Moreno gotro ja pisit amet?</div>
							<!--/content-title -->
							<!-- accordions content -->
							<div class="content">Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.</div>
							<!--/accordions content -->
						</div>
						<!--/accordions -->

					</div>
					<div class="grid-col grid-col-6">
						<div class="owl-carousel full-width-slider">
							<div class="gallery-item picture">
								<img src="/frontend/uploads/570x380-img-2.jpg" data-at2x="/frontend/uploads/570x380-img-2@2x.jpg" alt>
							</div>
							<div class="gallery-item picture">
								<img src="/frontend/uploads/570x380-img-1.jpg" data-at2x="/frontend/uploads/570x380-img-1@2x.jpg" alt>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<hr class="divider-color" />
		<!-- section -->
		<section class="padding-section">
			<div class="grid-row clear-fix">
				<div class="grid-col-row">
					<div class="grid-col grid-col-6">
						<div class="video-player">
							<iframe src="https://www.youtube.com/embed/rZsH88zNxRw"></iframe>
						</div>
					</div>
					<div class="grid-col grid-col-6 clear-fix">
						<h2>Learn More About Us From Video</h2>
						<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at susp. Vivamus orci urna, ornare vitae
							tellus in, condimentum imperdiet eros. Maecea accumsan, massa nec vulputate congue.</p>
						<p>Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque
							rutrum.
						</p>
						<br/>
						<br/>
						<br/>
						<br/>
						<a href="https://www.youtube.com" class="cws-button bt-color-3 border-radius alt icon-right float-right">Watch More
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</section>
		<!-- / section -->
		<hr class="divider-color" />
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
						<h2>Our Services</h2>
						<p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at susp. Vivamus orci urna, ornare vitae
							tellus in, condimentum imperdiet eros. Maecea accumsan, massa nec vulputate congue. Maecenas nec odio et ante tincidunt
							creptus alarimus tempus.</p>

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
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="flaticon-multiple"></i>
							<div class="counter" data-count="4781">0</div>
							<div class="counter-name">Students Enrolled</div>
						</div>
					</div>
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="sms-icon-group"></i>
							<div class="counter" data-count="356">0</div>
							<div class="counter-name">Teachers
							</div>
						</div>
					</div>
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="flaticon-college"></i>
							<div class="counter" data-count="1500">0</div>
							<div class="counter-name">Passing to College</div>
						</div>
					</div>
					<div class="grid-col grid-col-3 alt">
						<div class="counter-block">
							<i class="flaticon-book1 last"></i>
							<div class="counter" data-count="17030">0</div>
							<div class="counter-name">Books</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- / paralax section -->

		<hr class="divider-color" />
		<!-- / section -->
		<section class="fullwidth-background testimonial padding-section">
			<div class="grid-row">
				<h2 class="center-text">Testimonials</h2>
				<div class="owl-carousel testimonials-carousel">
					<div class="gallery-item">
						<div class="quote-avatar-author clear-fix">
							<img src="/frontend/uploads/94x94-img-1.jpg" data-at2x="/frontend/uploads/94x94-img-1@2x.jpg" alt="">
							<div class="author-info">Karl Doe
								<br>
								<span>Writer</span>
							</div>
						</div>
						<p>Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat
							vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla
							ut metus varius laoreet. </p>
					</div>
					<div class="gallery-item">
						<div class="quote-avatar-author clear-fix">
							<img src="/frontend/uploads/94x94-img-1.jpg" data-at2x="/frontend/uploads/94x94-img-1@2x.jpg" alt="">
							<div class="author-info">Karl Doe
								<br>
								<span>Writer</span>
							</div>
						</div>
						<p>Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat
							vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla
							ut metus varius laoreet. </p>
					</div>
					<div class="gallery-item">
						<div class="quote-avatar-author clear-fix">
							<img src="/frontend/uploads/94x94-img-1.jpg" data-at2x="/frontend/uploads/94x94-img-1@2x.jpg" alt="">
							<div class="author-info">Karl Doe
								<br>
								<span>Writer</span>
							</div>
						</div>
						<p>Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat
							vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla
							ut metus varius laoreet. </p>
					</div>
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
				<img src="/frontend/img/parallax.png" alt="">
			</div>
			<div class="them-mask bg-color-4"></div>
			<div class="grid-row center-text">
				<div class="font-style-1 margin-none">Get In Touch With Us</div>
				<div class="divider-mini"></div>
				<p class="parallax-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis
					natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
				<form class="subscribe">
					<input type="text" name="email" value="" size="40" placeholder="Enter your email" aria-required="true">
					<input type="submit" value="Subscribe">
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


