@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.menu_timeline') @endsection

@section('pageBreadCrumb')
	<!-- page title -->
	<div class="page-title">
		<div class="grid-row">
			<h1>@lang('site.menu_timeline')</h1>
			<nav class="bread-crumb">
				<a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
				<i class="fa fa-long-arrow-right"></i>
				<a href="#">@lang('site.menu_timeline')</a>
			</nav>
		</div>
	</div>
	<!-- / page title -->
@endsection

@section('pageContent')
	<!-- content -->
	<div class="page-content">
		<!-- content  -->
		<div class="grid-row">
			<h2 class="center-text">@lang('site.timeline_title')</h2>
			<div class="time-line">
				@foreach($timeline as $line)
					@php
						$l = json_decode($line->meta_value);
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
					<div class="line-element @if($styleValue==2) color-2 @elseif($styleValue==3) color-3 @endif">
						@if($loop->iteration%2 != 0)
							<div class="level">
								<div class="level-block">{{$l->y}}</div>
							</div>
						@endif
						<div class="action">
							<div class="action-block">
                            <span>
                                <i class="flaticon-magnifier"></i>
                            </span>
								<div class="text">
									<h3>{{$l->t}}</h3>
									<p>{{$l->d}}</p>
								</div>
							</div>
						</div>
						@if($loop->iteration%2 == 0)
							<div class="level">
								<div class="level-block">{{$l->y}}</div>
							</div>
						@endif

					</div>
				@endforeach
			</div>
		</div>

		<!-- / content  -->
@endsection
