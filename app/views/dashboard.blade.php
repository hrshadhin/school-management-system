@extends('layouts.master')
@section("style")
<style>
.fc-today{
   background-color: #2AA2E6;
   color:#fff;


}
.fc-button-today
{
  display: none;
}
</style>
@stop
@section('content')
    @if (Session::get('accessdined'))
        <div class="alert alert-danger">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Process Faild.</strong> {{ Session::get('accessdined')}}

        </div>
    @endif

<div class=" row">
    <div class="col-md-4 col-sm-4 col-xs-6">
        <a href="/class/list" class="well top-block" title="" data-toggle="tooltip" data-original-title="Click To View Details">
            <i class="glyphicon glyphicon-home blue"></i>

            <div>Total Class</div>
            <div>{{$tclass}}</div>

        </a>
    </div>

    <div class="col-md-4 col-sm-4 col-xs-6">
        <a href="/subject/list" class="well top-block" title="" data-toggle="tooltip" data-original-title="Click To View Details">
            <i class="glyphicon glyphicon-book blue"></i>

            <div>Total Subject</div>
            <div>{{$tsubject}}</div>

        </a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-6">
        <a href="/student/list" class="well top-block" title="" data-toggle="tooltip" data-original-title="Click To View Details">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Total Student</div>
            <div>{{$tstudent}}</div>

        </a>
    </div>


</div>

<div class="row">
       <div class="box col-md-12">
           <div class="box-inner">
               <div class="box-header well" data-original-title="">
                   <h2><i class="glyphicon glyphicon-calendar"></i> Calendar</h2>

               </div>
               <div class="box-content">

                   <div id="calendar"></div>

                   <div class="clearfix"></div>
               </div>
           </div>
       </div>
   </div><!--/row-->
@stop
@section("script")

@stop
