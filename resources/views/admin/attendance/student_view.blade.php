<h4>Check for Present and Un-check for Absent</h4>

<table class="table table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Roll No</th>
            <th>Student Name</th>
            <th>Attendance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $student)
        <tr>
            <td>{{ $student->roll_no }}</td>
            <td>{{ $student->name }}</td>
            <td>
                <input type="text" class="hide" name="student[{{ $student->id }}]">
                <input type="checkbox" name="attendance[{{ $student->id }}]"/>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


