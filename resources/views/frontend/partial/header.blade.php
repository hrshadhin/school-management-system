<header>
	<!-- header top panel -->
	<div class="page-header-top">
		<div class="grid-row clear-fix">
			<address>
				<a href="tel:{{$siteInfo['phone']}}" class="phone-number">
					<i class="fa fa-phone"></i>{{$siteInfo['phone']}}</a>
				<a href="mailto:{{$siteInfo['email']}}" class="email">
					<i class="fa fa-envelope-o"></i>
					<span class="">{{$siteInfo['email']}}</span>
				</a>
			</address>
			<div class="header-top-panel">
				<a href="/login" class="fa fa-user login-icon"></a>
				<div id="top_social_links_wrapper">
					<div class="share-toggle-button">
						<i class="share-icon fa fa-share-alt"></i>
					</div>
					<div class="cws_social_links">
						<a target="_blank" href="@if($siteInfo['google']){{$siteInfo['google']}}@else #@endif" class="cws_social_link" title="Google +">
							<i class="share-icon fa fa-google-plus" style="transform: matrix(0, 0, 0, 0, 0, 0);"></i>
						</a>
						<a target="_blank" href="@if($siteInfo['twitter']){{$siteInfo['twitter']}}@else #@endif" class="cws_social_link" title="Twitter">
							<i class="share-icon fa fa-twitter"></i>
						</a>
						<a target="_blank" href="@if($siteInfo['facebook']){{$siteInfo['facebook']}}@else #@endif" class="cws_social_link" title="Facebook">
							<i class="share-icon fa fa-facebook"></i>
						</a>
						<a target="_blank" href="@if($siteInfo['youtube']){{$siteInfo['youtube']}}@else #@endif" class="cws_social_link" title="Youtube">
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
					<img src="{{asset('storage/site/'.$siteInfo['logo'])}}" data-at2x="{{asset('storage/site/'.$siteInfo['logo2x'])}}" alt>
					<h1>{{$siteInfo['name']}}</h1>
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
							<a href="{{URL::route('site.gallery_view')}}" @if(Route::current()->getName() == "site.gallery_view" ) class="active" @endif>Gallery</a>
						</li>
						<li>
							<a href="{{URL::route('site.contact_us_view')}}" @if(Route::current()->getName() == "site.contact_us_view" ) class="active" @endif>Contact Us</a>
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
    