@extends('layouts.master')
@section('content')
@if (Session::get('success'))
<div class="alert alert-success">
  <button data-dismiss="alert" class="close" type="button">×</button>
    <strong>Process Success.</strong><br>{{ Session::get('success')}}<br>
</div>

@endif
<div class="row">
<div class="box col-md-12">
        <div class="box-inner">
            <div data-original-title="" class="box-header well">
                <h2><i class="glyphicon glyphicon-book"></i> Subject List</h2>

            </div>
            <div class="box-content">
              <table id="subjectList" class="table table-striped table-bordered table-hover">
                                                         <thead>
                                                             <tr>
                                                               <th>Code</th>
                                                                 <th>Name</th>
                                                                 <th>Type</th>
                                                                 <th>Group</th>
                                                                 <th>Student Group</th>
                                                                 <th>Class</th>
                                                                 <th>Grade System</th>
                                                                    <th>
                                                                      Full Marks
                                                                    </th>
                                                                    <th>
                                                                      Pass Marks
                                                                    </th>

                                                                  <th>Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                           @foreach($Subjects as $subject)
                                                             <tr><td>{{$subject->code}}</td>
                                                               <td>{{$subject->name}}</td>
                                                                      <td>{{$subject->type}}</td>
                                                                             <td>{{$subject->subgroup}}</td>
                                                                             <td>{{$subject->stdgroup}}</td>
                                                                  <td>{{$subject->class}}</td>
                                                                  @if($subject->gradeSystem=="1")
                                                                  <td>100 Marks</td>
                                                                @else
                                                                    <td>50 Marks</td>
                                                                @endif
                                                                    <td>
                                                                    {{$subject->totalfull.' [Total] '}}
                                                                      {{$subject->wfull.' [Written] '}}
                                                                        {{$subject->mfull.' [MCQ] '}}
                                                                          {{$subject->sfull.' [SBA] '}}
                                                                            {{$subject->pfull.' [Practical]'}}
                                                                    </td>
                                                                    <td>
                                                                    {{$subject->totalpass.' [Total] '}}
                                                                    {{$subject->wpass.' [Written] '}}
                                                                      {{$subject->mpass.' [MCQ] '}}
                                                                        {{$subject->spass.' [SBA] '}}
                                                                          {{$subject->ppass.' [Practical] '}}
                                                                    </td>
                                                       <td>
                                                  <a title='Edit' class='btn btn-info' href='{{url("/subject/edit")}}/{{$subject->id}}'> <i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger' href='{{url("/subject/delete")}}/{{$subject->id}}'> <i class="glyphicon glyphicon-trash icon-white"></i></a>
                                                               </td>
                                                           @endforeach
                                                           </tbody>
                                </table>
                                <br><br>


        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#subjectList').dataTable();
    });
</script>
@stop
