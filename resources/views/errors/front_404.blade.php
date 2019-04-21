@extends('frontend.layouts.master')
@section('pageTitle') @lang('site.not_found') @endsection

@section('pageBreadCrumb')
    <!-- page title -->
    <div class="page-title">
        <div class="grid-row">
            <h1>@lang('site.not_found')</h1>
            <nav class="bread-crumb">
                <a href="{{URL::route('home')}}">@lang('site.menu_home')</a>
                <i class="fa fa-long-arrow-right"></i>
                <a href="#">@lang('site.not_found')</a>
            </nav>
        </div>
    </div>
    <!-- / page title -->
@endsection

@section('pageContent')
    <!-- content -->
    <div class="page-content">
        <div class="container clear-fix">
            <div class="container-404">
                <div class="number">{{AppHelper::translateNumber('4')}}
                    <span>{{AppHelper::translateNumber('0')}}</span>{{AppHelper::translateNumber('4')}}</div>
                <p>
                    <span>:(</span>
                    <br/>@lang('site.not_found_title')</p>
                <a href="{{route('home')}}" class="cws-button border-radius alt">@lang('site.menu_home')</a>
            </div>

        </div>
    </div>
    <!-- / content -->
@endsection
