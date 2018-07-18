<header>
	<!-- header top panel -->
	<div class="page-header-top">
		<div class="grid-row clear-fix">
			<address>
				<a href="tel:+8801123456789" class="phone-number">
					<i class="fa fa-phone"></i>+8801123456789</a>
				<a href="mailto:info@shanixlab.com" class="email">
					<i class="fa fa-envelope-o"></i>
					<span class="">info@shanixlab.com</span>
				</a>
			</address>
			<div class="header-top-panel">
				<a href="/login" class="fa fa-user login-icon"></a>
				<div id="top_social_links_wrapper">
					<div class="share-toggle-button">
						<i class="share-icon fa fa-share-alt"></i>
					</div>
					<div class="cws_social_links">
						<a href="https://plus.google.com/" class="cws_social_link" title="Google +">
							<i class="share-icon fa fa-google-plus" style="transform: matrix(0, 0, 0, 0, 0, 0);"></i>
						</a>
						<a href="https://twitter.com/" class="cws_social_link" title="Twitter">
							<i class="share-icon fa fa-twitter"></i>
						</a>
						<a href="https://facebook.com/" class="cws_social_link" title="Facebook">
							<i class="share-icon fa fa-facebook"></i>
						</a>
						<a href="https://youtube.com/" class="cws_social_link" title="Youtube">
							<i class="share-icon fa fa-youtube"></i>
						</a>
					</div>

				</div>
				<div id="top_lang_links_wrapper">
					<div class="lang-toggle-button">
						<i class="fa fa-language"></i>
					</div>

					<div class="cws_lang_links">
						<a href="/bn" class="cws_lang_link" title="Bangla">
							<i class="lang-icon flag-icon flag-icon-bd"></i>
						</a>
						<a href="/en" class="cws_lang_link" title="English">
							<i class="lang-icon flag-icon flag-icon-gb"></i>
						</a>
						<a href="/in" class="cws_lang_link" title="Hindi">
							<i class="lang-icon flag-icon flag-icon-in"></i>
						</a>
					</div>
				</div>


			</div>
		</div>
	</div>
	<!-- / header top panel -->
	<!-- sticky menu -->
	<div class="sticky-wrapper">
		<div class="sticky-menu">
			<div class="grid-row clear-fix">
				<!-- logo -->
				<a href="{{URL::route('home')}}" class="logo">
					<img src="/frontend/img/logo.png" data-at2x="/frontend/img/logo@2x.png" alt>
					<h1>HR High School</h1>
				</a>
				<!-- / logo -->
				<nav class="main-nav">
					<ul class="clear-fix">
						<li>
							<a href="{{URL::route('home')}}" @if(Route::current()->getName() == "home") class="active" @endif>Home</a>
						</li>
						<li>
							<a href="{{URL::route('site.class_profile')}}" @if(Route::current()->getName() == "site.class_profile" || Route::current()->getName() == "site.class_details" ) class="active" @endif>Class</a>
						</li>
						<li>
							<a href="{{URL::route('site.teacher_profile')}}" @if(Route::current()->getName() == "site.teacher_profile") class="active" @endif>Teachers</a>
						</li>
						<li>
							<a href="{{URL::route('site.event')}}" @if(Route::current()->getName() == "site.event" || Route::current()->getName() == "site.event_details" ) class="active" @endif>Events</a>

						</li>
						<li>
							<a href="gallery.html">Gallery</a>
						</li>

						<li>
							<a href="contact-us.html">Contact Us</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<!-- sticky menu -->
	<!-- BEGIN Bread Crumb-->
	@yield('pageBreadCrumb')
	<!-- End Bread Crumb-->
</header>
    