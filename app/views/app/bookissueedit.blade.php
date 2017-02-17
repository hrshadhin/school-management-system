@extends('layouts.master')
@section('style')
    <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
@if (Session::get('success'))

<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong> {{ Session::get('success')}}<br><a href="/library/issuebookview">View List</a><br>

</div>
@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i> Borrow Book Update</h2>

            </div>
            <div class="box-content">
                @if (isset($book))
                                    <div class="row">
                                <div class="col-md-12">
                                  @if (count($errors) > 0)
                                                        <div class="alert alert-danger">
                                                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                        @endif
                                    </div>
                                  </div>

                            <form role="form" action="/library/issuebookupdate" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$book->id}}">
                    <div class="row">
                      <div class="col-md-12">
                          <h3 class="text-info"> Book Issue Details</h3>
                          <hr>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">Student Regi No</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                  <input type="text" class="form-control" required name="regiNo" value="{{$book->regiNo}}">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">Book Code/ISBN No</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                              <input type="text" class="form-control" required name="code" value="{{$book->code}}">
                              </div>
                          </div>
                        </div>


                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label for="idate">Issue Date</label>
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                    <input type="text"   class="form-control datepicker" name="issueDate" required value="{{Carbon\Carbon::createFromFormat('Y-m-d',$book->issueDate)->format('d/m/Y')}}" data-date-format="dd/mm/yyyy">
                                </div>


                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label for="rdate">Return Date</label>
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                    <input type="text"   class="form-control datepicker" name="returnDate" required value="{{Carbon\Carbon::createFromFormat('Y-m-d',$book->returnDate)->format('d/m/Y')}}" data-date-format="dd/mm/yyyy">
                                </div>


                            </div>
                        </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label class="control-label" for="fine">Fine</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign  blue"></i></span>
                                      <input type="text" class="form-control"  name="fine" value="{{$book->fine}}">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group ">
                                  <label for="idate">Status</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                      <select name="status" class="form-control">
                                        <option value="">Status</option>
                                        @if($book->Status=="Borrowed")

                                          <option selected="true" value="Borrowed">Borrowed</option>
                                         <option value="Returned">Returned</option>
                                        @else
                                        <option  value="Borrowed">Borrowed</option>
                                        <option selected="true" value="Returned">Returned</option>
                                        @endif

                                      </select>
                                  </div>


                              </div>
                          </div>
                        </div>
                    </div>




                <div class="row">
                <div class="col-md-12">

                    <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-plus"></i> Update</button>

                  </div>
                </div>
                @else
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong>There is no such record!<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                         @endif

                </form>

        </div>
    </div>
</div>
</div>
@stop
@section('script')
    <script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">

        $( document ).ready(function() {

            $(".datepicker").datepicker({autoclose:true,defaultDate:'now',todayHighlight: true});

          });

    </script>

@stop
