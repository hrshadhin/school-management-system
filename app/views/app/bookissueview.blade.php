@extends('layouts.master')
@section('style')
      <link href="<?php  echo url();?>/css/bootstrap-datepicker.css" rel="stylesheet">

@stop
@section('content')
@if (Session::get('success'))
<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
</div>

@endif
@if (Session::get('error'))
    <div class="alert alert-warning">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong> {{ Session::get('error')}}</strong>

    </div>
@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i> Borrowed Books List</h2>

            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">

                        <form role="form" action="/library/issuebookview" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <span class="text-danger">[*] Fill at least one feild from first 4 feilds or just select status and get list</span>
                            <div class="row">
                                <div class="col-md-12">

                                  <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name">Student Regi No</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <input type="text" class="form-control"  name="regiNo" placeholder="Student registration No">
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name">Book Code/ISBN No</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                                            <input type="text" class="form-control"  name="code" placeholder="Book Code">
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group ">
                                          <label for="idate">Issue Date</label>
                                          <div class="input-group">

                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                              <input type="text"   class="form-control datepicker" name="issueDate"   data-date-format="dd/mm/yyyy">
                                          </div>


                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group ">
                                          <label for="rdate">Return Date</label>
                                          <div class="input-group">

                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i> </span>
                                              <input type="text"   class="form-control datepicker" name="returnDate"   data-date-format="dd/mm/yyyy">
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
                                                  <option value="Borrowed">Borrowed</option>
                                                 <option value="Returned">Returned</option>

                                              </select>
                                          </div>


                                      </div>
                                  </div>
                                    <div class="col-md-2">
                                      <label for="">&nbsp;</label>
                                      <div class="input-group">
                                        <button class="btn btn-primary pull-right"  type="submit"><i class="glyphicon glyphicon-th"></i>Get List</button>
                                      </div>
                                    </div>

                                </div>
                            </div>

                                                      <br>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
              <table id="booklist" class="table table-striped table-bordered table-hover">
                                                         <thead>
                                                             <tr>

                                                                 <th>Std Reg No</th>
                                                                 <th>Code/ISBN No</th>
                                                                 <th>Quantity</th>
                                                                 <th>Issue Date</th>
                                                                 <th>Return Date</th>
                                                                  <th>Fine</th>
                                                                 <th>Status</th>

                                                                  <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                     @if(isset($books))
                                                           @foreach($books as $book)
                                                             <tr>
                                                                  <td>{{$book->regiNo}}</td>
                                                                     <td>{{$book->code}}</td>
                                                                     <td>{{$book->quantity}}</td>
                                                                     <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$book->issueDate)->format('d/m/Y')}}</td>
                                                                     <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$book->returnDate)->format('d/m/Y')}}</td>
                                                               <td>{{$book->fine}}</td>
                                                               <td>{{$book->Status}}</td>


                                                       <td>
                                                         @if($book->Status=='Borrowed')
                                                <a title='Edit' class='btn btn-success' href='{{url("/library/issuebookupdate")}}/{{$book->id}}'> <i class="glyphicon glyphicon-pencil icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/library/issuebookdelete")}}/{{$book->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                                    @endif
                                             </td>
                                                           @endforeach
                                                @endif
                                                           </tbody>
                                </table>
                        </div>
                    </div>
                                <br><br>


        </div>
    </div>
</div>
</div>
@stop
@section('script')

<script src="<?php echo url();?>/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('#booklist').dataTable();
    $(".datepicker").datepicker({autoclose:true,defaultDate:'now',todayHighlight: true});
});
</script>
@stop
