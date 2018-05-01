@extends('layouts.master')
@section('content')
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i>Applicant's Information</h2>

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
              @if (isset($student))
              <div class="row">
                <div class="col-md-12">
                 <h4>Academic Info :</h4>
               </div>
             </div>
             <div class="row">
               <div class="col-md-12">
                   <div class="col-md-2"></div>
                 <div class="col-md-3">
                   <strong class="text-info font-16" >Referance No :</strong>
                 </div>
                 <div class="col-md-7">
                   <label>{{$student->refNo}}</label>
                 </div>
                 </div>
                 </div>
                 <div class="row">
                   <div class="col-md-12">
                       <div class="col-md-2"></div>
                     <div class="col-md-3">
                       <strong class="text-info font-16" >Seat/Roll No :</strong>
                     </div>
                     <div class="col-md-7">
                       <label>{{$student->seatNo}}</label>
                     </div>
                     </div>
                     </div>
                     <div class="row">
                       <div class="col-md-12">
                           <div class="col-md-2"></div>
                         <div class="col-md-3">
                           <strong class="text-info font-16" >Class :</strong>
                         </div>
                         <div class="col-md-7">
                           <label>{{$student->class}} </label>
                         </div>
                         </div>
                         </div>

               <div class="row">
                 <div class="col-md-12">
                     <div class="col-md-2"></div>
                   <div class="col-md-3">
                     <strong class="text-info font-16" >Transaction NO :</strong>
                   </div>
                   <div class="col-md-7">
                     <label>{{$student->transactionNo}}</label>
                   </div>
                   </div>
                   </div>


                     <div class="row">
                       <div class="col-md-12">
                           <div class="col-md-2"></div>
                         <div class="col-md-3">
                           <strong class="text-info font-16" >Status :</strong>
                         </div>
                         <div class="col-md-7">
                           <label>{{$student->status}}</label>
                         </div>
                         </div>
                         </div>
                  <div class="row">
                    <div class="col-md-12">
                     <h4>General Details :</h4>
                   </div>
                 </div>
                       <div class="row">
               <div class="col-md-12">
                   <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <img class="img responsive-img" style="height:150px;width:200px;" src="<?php echo url();?>/admission/{{$student->photo}}" alt="Photo">
                    </div>
                       <div class="col-md-4"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">

                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                      <strong class="text-info font-16" >Fulle Name :</strong>
                    </div>
                    <div class="col-md-7">
                      <label>{{$student->stdName}} </label>
                    </div>
                    </div>
                    </div>


                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                      <strong class="text-info font-16" >Session :</strong>
                                    </div>
                                    <div class="col-md-7">
                                      <label>{{$student->session}} </label>
                                    </div>
                                    </div>
                                    </div>


                                                <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="col-md-2"></div>
                                                    <div class="col-md-3">
                                                      <strong class="text-info font-16" >Nationality :</strong>
                                                    </div>
                                                    <div class="col-md-7">
                                                      <label>{{$student->nationality}} </label>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                          <div class="col-md-2"></div>
                                                        <div class="col-md-3">
                                                          <strong class="text-info font-16" >Date Of Birth :</strong>
                                                        </div>
                                                        <div class="col-md-7">
                                                          <label>{{$student->dob}} </label>
                                                        </div>
                                                        </div>
                                                        </div>


                                                <div class="row">
                                                  <div class="col-md-12">
                                                   <h4>Quota :</h4>
                                                 </div>
                                               </div>

                            <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-2"></div>
                                <div class="col-md-3">
                                  <strong class="text-info font-16" >Campus :</strong>
                                </div>
                                <div class="col-md-7">
                                  <label>{{$student->campus}} </label>
                                </div>
                                </div>
                                </div>
                            <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-2"></div>
                                <div class="col-md-3">
                                  <strong class="text-info font-16" >Keeping :</strong>
                                </div>
                                <div class="col-md-7">
                                  <label>{{$student->keeping}} </label>
                                </div>
                                </div>
                                </div>


                                                                <div class="row">
                                                                  <div class="col-md-12">
                                                                   <h4>Guardian's Details :</h4>
                                                                 </div>
                                                               </div>
                                                               <div class="row">
                                                                 <div class="col-md-12">
                                                                     <div class="col-md-2"></div>
                                                                   <div class="col-md-3">
                                                                     <strong class="text-info font-16" >Father's Name :</strong>
                                                                   </div>
                                                                   <div class="col-md-7">
                                                                     <label>{{$student->fatherName}} </label>
                                                                   </div>
                                                                   </div>
                                                                   </div>
                                                                   <div class="row">
                                                                     <div class="col-md-12">
                                                                         <div class="col-md-2"></div>
                                                                       <div class="col-md-3">
                                                                         <strong class="text-info font-16" >Father's Cell No :</strong>
                                                                       </div>
                                                                       <div class="col-md-7">
                                                                         <label>{{$student->fatherCellNo}} </label>
                                                                       </div>
                                                                       </div>
                                                                       </div>
                                                                       <div class="row">
                                                                         <div class="col-md-12">
                                                                             <div class="col-md-2"></div>
                                                                           <div class="col-md-3">
                                                                             <strong class="text-info font-16" >Mother's Name :</strong>
                                                                           </div>
                                                                           <div class="col-md-7">
                                                                             <label>{{$student->motherName}} </label>
                                                                           </div>
                                                                           </div>
                                                                           </div>
                                                                           <div class="row">
                                                                             <div class="col-md-12">
                                                                                 <div class="col-md-2"></div>
                                                                               <div class="col-md-3">
                                                                                 <strong class="text-info font-16" >Mother's Cell No :</strong>
                                                                               </div>
                                                                               <div class="col-md-7">
                                                                                 <label>{{$student->motherCellNo}} </label>
                                                                               </div>
                                                                               </div>
                                                                               </div>




                @else
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong>There is no such applicant!<br><br>
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
$(function(){

});

</script>
@stop
