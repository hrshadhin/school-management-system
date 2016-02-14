<html>

<body> Total Registered User :
<table>
    <thead>
    <tr>
        <th colspan="2">Class:</th>
        <th colspan="2">{{$input[0]}}</th>
    </tr>
    <tr>
        <th colspan="2">Section:</th>
        <th colspan="2">{{$input[1]}}</th>

    </tr>
    <tr>
        <th colspan="2">Shift:</th>
        <th colspan="2">{{$input[2]}}</th>

    </tr>
    <tr>
        <th colspan="2">Session:</th>
        <th colspan="2">{{$input[3]}}</th>

    </tr>
    <tr>
        <th colspan="2">Subject:</th>
        <th colspan="2">{{$input[4]}}</th>

    </tr>
    <tr>
        <th colspan="2">Date:</th>
        <th colspan="2">{{$input[5]}}</th>

    </tr>
    </thead>
</table>
<table>
    <thead>
    <tr>
        <th colspan="2">Registration No</th>
        <th colspan="2">Roll No</th>
        <th colspan="2">Name </th>
        <th colspan="2">Is Present </th>
    </tr>
    </thead>
      @foreach($attendance as $student)
        <tr>
            <td colspan="2">{{$student->regiNo}}</td>
            <td colspan="2">{{$student->rollNo}}</td>
            <td colspan="2">{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>

            <td colspan="2">{{$student->status}}</td>

        </tr>
    @endforeach

</table>
</body>
</html>