@extends('layouts.master')
@section('content')

<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i> Marks Edit</h2>

            </div>
            <div class="box-content">
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
                    @if (isset($marks))
                   <form role="form" action="/mark/update" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="hidden" name="id" value="{{$marks->id }}">
		   <input type="hidden" name="subject" value="{{$marks->subject }}">
		    <input type="hidden" name="class" value="{{$marks->class }}">
                   <div class="row">
                   <div class="col-md-12">
                     <div class="col-md-4">
                       <div class="form-group">
                           <label for="regiNo">Regi No</label>
                           <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                               <input type="text" class="form-control" readonly="true"  name="regiNo" value="{{$marks->regiNo}}">
                           </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-group">
                           <label for="rollNo">Roll No</label>
                           <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                               <input type="text" class="form-control" readonly="true"  name="rollNo" value="{{$marks->rollNo}}">
                           </div>
                       </div>
                     </div>
                     <div class="col-md-5">
                       <div class="form-group">
                           <label for="name">Name</label>
                           <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                               <input type="text" class="form-control" readonly="true"  name="name" value="{{$marks->firstName}} {{$marks->middleName}} {{$marks->lastName}}">
                           </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                 <div class="col-md-12">
                   <div class="col-md-2">
                     <div class="form-group">
                         <label for="written">Written</label>
                         <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                             <input type="text" class="form-control" required="true"  name="written" value="{{$marks->written}}">
                         </div>
                     </div>
                   </div>
                   <div class="col-md-2">
                     <div class="form-group">
                         <label for="mcq">MCQ</label>
                         <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                             <input type="text" class="form-control" required="true"  name="mcq" value="{{$marks->mcq}}">
                         </div>
                     </div>
                   </div>
                   <div class="col-md-2">
                     <div class="form-group">
                         <label for="practical">Practical</label>
                         <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                             <input type="text" class="form-control" required="true"   name="practical" value="{{$marks->practical}}">
                         </div>
                     </div>
                   </div>
                   <div class="col-md-2">
                     <div class="form-group">
                         <label for="ca">SBA</label>
                         <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                             <input type="text" class="form-control" required="true"   name="ca" value="{{$marks->ca}}">
                         </div>
                     </div>
                   </div>
                   <div class="col-md-2">
                     <div class="form-group">
                         <label for="Absent">Absent</label>
                         <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign blue"></i></span>
                             <input type="text" class="form-control" required="true"   name="Absent" value="{{$marks->Absent}}">
                         </div>
                     </div>
                   </div>
                 </div>
               </div>

               <div class="row">
               <div class="col-md-12">
                   <button class="btn btn-primary pull-right" type="submit"><i class="glyphicon glyphicon-check"></i>Update</button>
                 </div>
               </div>
                 </form>
                @else
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong>There is no such Student!<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                         @endif





        </div>
    </div>
</div>
</div>
@stop
@section('script')

<script type="text/javascript">

</script>
@stop
