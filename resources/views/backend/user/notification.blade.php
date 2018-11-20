<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Notification @endsection
<!-- End block -->

@section('extraStyle')
    <style>
        .notification li {
            font-size: 16px;
        }
        .notification li.info span.badge {
            background: #00c0ef;
        }
        .notification li.warning span.badge {
            background: #f39c12;
        }
        .notification li.success span.badge {
            background: #00a65a;
        }
        .notification li.error span.badge {
            background: #dd4b39;
        }
    </style>
@endsection

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Notification
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('user.index')}}"><i class="fa fa-user"></i> User</a></li>
            <li class="active">Notification</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <a class="btn btn-warning @if($type == 'unread') disabled @endif" href="{{ URL::route('user.notification_unread') }}"><i class="fa fa-envelope"></i> Unread</a>
                            <a class="btn btn-info @if($type == 'read') disabled @endif" href="{{ URL::route('user.notification_read') }}"><i class="fa fa-envelope-open"></i> Read</a>
                            <a class="btn btn-primary @if($type == 'all') disabled @endif" href="{{ URL::route('user.notification_all') }}"><i class="fa fa-list-alt"></i> All</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body margin-top-20">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                @if(count($messages))
                                @if($type == 'unread') <a class="btn btn-info btn_mark_as_read" href="?action=mark_as_read"><i class="fa fa-envelope-open"></i> Mark as Read</a> @endif
                                <a class="btn btn-danger" href="?action=delete"><i class="fa fa-trash"></i> Delete</a>
                                @endif
                                <ul class="list-group notification">
                                    @foreach($messages as $message)
                                    <li class="list-group-item {{$message['type']}}">
                                        <a href="#">
                                            <i class="fa @if($message['type'] == 'info') fa-info-circle text-info @elseif($message['type'] == 'warning') fa-warning text-yellow @elseif($message['type'] == 'success') fa-check-circle text-success @else fa-times-circle text-danger @endif"></i> {{$message['message']}}
                                        </a>
                                        <span class="badge badge-pill">{{$message['created_at']}}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn_mark_as_read').click(function(e){
                localStorage.removeItem('notiCallTime');
                localStorage.removeItem('notifications');
            });
        });
    </script>
@endsection
<!-- END PAGE JS-->
