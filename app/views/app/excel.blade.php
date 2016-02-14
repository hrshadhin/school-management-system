<html>

<body> Total Registered User :
<table>
    <thead>
    <tr>
        <th colspan="2">Class Name:</th>
        <th colspan="2">{{$input->class}}</th>
    </tr>
    <tr>
        <th colspan="2">Section:</th>
        <th colspan="2">{{$input->section}}</th>

    </tr>
    <tr>
        <th colspan="2">Session:</th>
        <th colspan="2">{{$input->session}}</th>

    </tr>
    <tr>
        <th colspan="2">Examination:</th>
        <th colspan="2">{{$input->exam}}</th>

    </tr>
    </thead>
    </table>
<table>
    <thead>
    <tr>
        <th colspan="2">Name</th>
        @foreach($subjects as $subject)
        <th style="text-align: center" colspan="6">{{$subject->name}}</th>
        @endforeach
    </tr>
    </thead>
    <tr>
        <td colspan="2"></td>
    @foreach($subjects as $subject)
    <td >Written</td>
    <td >MCQ</td>
    <td>Practical</td>
    <td>SBA</td>
    <td>Total</td>
    <td>Grade</td>


    @endforeach
        <td>Grand Total</td>
        <td>Grade</td>
        <td>Point</td>
        <td>Merit Position</td>
        </tr>

        @foreach($students as $student)
        <tr>

            <td colspan="2">{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>
            @foreach($student->marks as $mark)
            <td >{{$mark->written}}</td>
            <td >{{$mark->mcq}}</td>
            <td>{{$mark->practical}}</td>
            <td>{{$mark->ca}}</td>
            <td>{{$mark->total}}</td>
            <td>{{$mark->grade}}</td>
            @endforeach
            <td>{{$student->meritdata->totalNo}}</td>
            <td>{{$student->meritdata->grade}}</td>
            <td>{{$student->meritdata->point}}</td>
            <td>{{$student->meritdata->position}}</td>

        </tr>
            @endforeach

        </table>
</body>
</html>