<header>
	<!-- header top panel -->
	<div class="page-header-top">
		<div class="grid-row clear-fix">
			<address>
				<a href="tel:{{$siteInfo['phone']}}" class="phone-number">
					<i class="fa fa-phone"></i>{{$siteInfo['phone']}}</a>
				<a href="mailto:{{$siteInfo['email']}}" class="email hidden-xs">
					<i class="fa fa-envelope-o"></i>
					<span class="">{{$siteInfo['email']}}</span>
				</a>
			</address>
			<div class="header-top-panel">
				<a title="login" href="{{route('login')}}" class="fa fa-sign-in login-icon"></a>
				<div title="social links" id="top_social_links_wrapper">
					<div class="share-toggle-button">
						<i class="share-icon fa fa-share-alt"></i>
					</div>
					<div class="cws_social_links">
						<a target="_blank" href="@if($siteInfo['facebook']){{$siteInfo['facebook']}}@else #@endif" class="cws_social_link" title="Facebook">
							<i class="share-icon fa fa-facebook"></i>
						</a>
						<a target="_blank" href="@if($siteInfo['instagram']){{$siteInfo['instagram']}}@else #@endif" class="cws_social_link" title="Instagram">
							<i class="share-icon fa fa-instagram" style="transform: matrix(0, 0, 0, 0, 0, 0);"></i>
						</a>
						<a target="_blank" href="@if($siteInfo['twitter']){{$siteInfo['twitter']}}@else #@endif" class="cws_social_link" title="Twitter">
							<i class="share-icon fa fa-twitter"></i>
						</a>
						<a target="_blank" href="@if($siteInfo['youtube']){{$siteInfo['youtube']}}@else #@endif" class="cws_social_link" title="Youtube">
							<i class="share-icon fa fa-youtube"></i>
						</a>
					</div>

				</div>
				<div title="language" id="top_lang_links_wrapper">
					<div class="lang-toggle-button">
						<i class="fa fa-language"></i>
					</div>

					<div class="cws_lang_links">
						<a href="{{route('setLocale','bn')}}" class="cws_lang_link" title="বাংলা">
							<i class="lang-icon flag-icon flag-icon-bd"></i>
						</a>
						<a href="{{route('setLocale','en')}}" class="cws_lang_link" title="English">
							<i class="lang-icon flag-icon flag-icon-gb"></i>
						</a>
						{{--<a href="/in" class="cws_lang_link" title="Hindi">--}}
							{{--<i class="lang-icon flag-icon flag-icon-in"></i>--}}
						{{--</a>--}}
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

					<img src="@if($siteInfo['logo']){{asset('storage/site/'.$siteInfo['logo'])}} @else{{ asset('frontend/img/logo.png') }}@endif" alt>
					<h1>{{$siteInfo['name']}}</h1>
				</a>
				<!-- / logo -->
				<nav class="main-nav">
					<ul class="clear-fix">
						<li>
							<a href="{{URL::route('home')}}" >@lang('site.menu_home')</a>
						</li>
						<li>
							<a href="{{URL::route('site.class_profile')}}"> @lang('site.menu_class') </a>
						</li>
						<li>
							<a href="{{URL::route('site.teacher_profile')}}" >@lang('site.menu_teachers')</a>
						</li>
						<li>
							<a href="{{URL::route('site.event')}}">@lang('site.menu_events')</a>

						</li>
						<li>
							<a href="{{URL::route('site.gallery_view')}}" >@lang('site.menu_gallery')</a>
						</li>
						<li>
							<a href="{{URL::route('site.contact_us_view')}}">@lang('site.menu_contact_us')</a>
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
    