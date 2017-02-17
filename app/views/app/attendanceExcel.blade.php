<html>

<body> Total Registered User :
  <table>
    <thead>
      <tr>
        <th colspan="2" style="color:#08C1EA" >Class:</th>
        <th colspan="2">{{$input[0]}}</th>
      </tr>
      <tr>
        <th colspan="2" style="color:#08C1EA" >Section:</th>
        <th colspan="2">{{$input[1]}}</th>

      </tr>
      <tr>
        <th colspan="2" style="color:#08C1EA" >Shift:</th>
        <th colspan="2">{{$input[2]}}</th>

      </tr>
      <tr>
        <th colspan="2" style="color:#08C1EA" >Session:</th>
        <th colspan="2">{{$input[3]}}</th>

      </tr>

      <tr>
        <th colspan="2" style="color:#08C1EA" >Date:</th>
        <th colspan="2">{{$input[4]}}</th>

      </tr>
    </thead>
  </table>
  <table>
    <thead>
      <tr>
        <th colspan="2" style="color:#08C1EA">Registration No</th>
        <th colspan="2" style="color:#08C1EA">Roll No</th>
        <th colspan="5" style="color:#08C1EA">Name </th>
        <th colspan="2" style="color:#08C1EA">Is Present </th>
      </tr>
    </thead>
    @foreach($attendance as $student)
    <tr>
      <td colspan="2">{{$student->regiNo}}</td>
      <td colspan="2">{{$student->rollNo}}</td>
      <td colspan="5">{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>
      @if(count($student->attendance))
      <td colspan="2" style="color:#05F210">
        Present
        @else
        <td colspan="2" style="color:#F22F05">
        Absent
       </td>
        @endif


    </tr>
    @endforeach

  </table>
</body>
</html>
