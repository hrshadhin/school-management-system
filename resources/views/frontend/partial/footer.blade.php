<footer>
		<div class="grid-row">
			<div class="grid-col-row clear-fix">
				<section class="grid-col grid-col-4 footer-about">
					<h2 class="corner-radius">@lang('site.menu_contact_us')</h2>
					<address>
						@if(isset($siteInfo['phone']) && isset($siteInfo['email']) && isset($siteInfo['address']))
						<p></p>
						<a href="tel:{{$siteInfo['phone']}}" class="phone-number">{{$siteInfo['phone']}}</a>
						<br />
						<a href="mailto:{{$siteInfo['email']}}" class="email">
							<span class="">{{$siteInfo['email']}}</span>
						</a>
						<br />
						<a href="{{URL::route('site.contact_us_view')}}" class="address">{{$siteInfo['address']}}</a>
							@else
							<p> @lang('site.empty_content') </p>
						@endif
					</address>

				</section>
				<section class="grid-col grid-col-4 footer-latest">
					<h2 class="corner-radius">@lang('site.up_event')</h2>
					@if($event)
					<article>
						<img src="{{asset('frontend/img/event.png')}}" alt>
						<h3>
							<a href="{{URL::route('site.event_details',$event->slug)}}">{{$event->title}}</a>
						</h3>
						<br>
						<div class="course-date">
							<div>
								<sub>{{$event->event_time->format('h:i a')}}</sub>
							</div>
							<div>{{$event->event_time->format('d.m.y')}}</div>
						</div>

					</article>
					@endif
				</section>
				<section class="grid-col grid-col-4 footer-links">
					<h2 class="corner-radius">@lang('site.help_links')
						<i class="site"></i>
					</h2>
					<ul class="clear-fix">
						<li>
							<a href="{{URL::route('site.faq_view')}}">@lang('site.menu_faq')</a>
						</li>
						<li>
							<a href="#">@lang('site.menu_admission')</a>
						</li>
						<li>
							<a href="{{route('report.marksheet_pub')}}">@lang('site.menu_result')</a>
						</li>
					</ul>
					<ul class="clear-fix">
						<li>
							<a href="{{URL::route('site.timeline_view')}}">@lang('site.menu_timeline')</a>

						</li>
						<li>
							<a href="{{URL::route('site.gallery_view')}}">@lang('site.menu_gallery')</a>
						</li>

						<li>
							<a href="{{URL::route('site.contact_us_view')}}">@lang('site.menu_contact_us')</a>
						</li>
					</ul>
				</section>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="grid-row clear-fix">
				<div class="copyright">{{$siteInfo['name']}}
					<span></span> @lang('site.copy_right')
				</div>

				<div class="footer-social">
					<a target="_blank" href="@if($siteInfo['facebook']){{$siteInfo['facebook']}}@else #@endif" class="fa fa-facebook"></a>
					<a target="_blank" href="@if($siteInfo['instagram']){{$siteInfo['instagram']}}@else #@endif" class="fa fa-instagram"></a>
					<a target="_blank" href="@if($siteInfo['twitter']){{$siteInfo['twitter']}}@else #@endif" class="fa fa-twitter"></a>
					<a target="_blank" href="@if($siteInfo['youtube']){{$siteInfo['youtube']}}@else #@endif" class="fa fa-youtube"></a>
				</div>

				<div class="maintainedby">@lang('site.maintainer')
					<a href="{{$maintainer_url}}" class="site">{{$maintainer}}</a>
				</div>
			</div>
		</div>
	</footer>