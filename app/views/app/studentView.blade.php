@extends('layouts.master')
@section('content')
  <div class="row">
    <div class="box col-md-12">
      <div class="box-inner">
        <div data-original-title="" class="box-header well">
          <h2><i class="glyphicon glyphicon-book"></i> Student Information</h2>

        </div>
        <div class="box-content">
          @if (isset($student))
            <div class="row">
              <div class="col-md-12">
                <h1 class="text-center">Student's Information</h1>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4>Academic Details :</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <img class="img responsive-img" style="height:150px;width:200px;" src="<?php echo url();?>/images/{{$student->photo}}" alt="Photo">
                </div>
                <div class="col-md-4"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Registration No :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->regiNo}}</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Card/Roll No :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->rollNo}}</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Sift :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->shift}}</label>
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
                  <strong class="text-info font-16" >Group :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->group}} </label>
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
                  <strong class="text-info font-16" >Section :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->section}} </label>
                </div>
              </div>
            </div>
            @if($student->fourthSubject && strlen($student->fourthSubject))
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >4th subject code :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->fourthSubject}} </label>
                </div>
              </div>
            </div>
            @endif
                @if($student->cphsSubject && strlen($student->cphsSubject))
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Alternate subject code :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->cphsSubject}} </label>
                </div>
              </div>
            </div>
            @endif


            <div class="row">
              <div class="col-md-12">
                <h4>Basic Details :</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">

                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Fulle Name :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Gender :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->gender}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Religion :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->religion}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Bloodgroup :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->bloodgroup}} </label>
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
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Extra Curicular Activity :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->extraActivity}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Remarks :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->remarks}} </label>
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
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Local Guardian :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->localGuardian}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Local Guardian Cell No :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->localGuardianCell}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4>Address Details:</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Present Address :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->presentAddress}} </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                  <strong class="text-info font-16" >Parmanent Address :</strong>
                </div>
                <div class="col-md-7">
                  <label>{{$student->parmanentAddress}} </label>
                </div>
              </div>
            </div>


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
      $(function(){
          $('#profiletabs ul li a').on('click', function(e){
              e.preventDefault();
              var newcontent = $(this).attr('href');

              $('#profiletabs ul li a').removeClass('sel');
              $(this).addClass('sel');

              $('#content section').each(function(){
                  if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
              });

              $(newcontent).removeClass('hidden');
          });
      });

  </script>
@stop
