<table class="table table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            @if($type == "Yes")
            <th>Subjects</th>
            <th>Th Full Marks</th>
            <th>Pr Full Marks</th>
            <th>Th Obtained Marks</th>
            <th>Pr Obtained Marks</th>
            @else

            <th>Subjects</th>
            <th>Full Marks</th>
            <th>Pass Marks</th>
            <th>Obtained Marks</th>

            @endif
        </tr>
    </thead>
    <tbody>
        @if($type=="Yes")
            @foreach($subjects as $subject)
            <tr>
                <td>{{ '[ '.$subject->code.'] '.$subject->name }}</td>
                <td>{{ $subject->theory_full_marks }}</td>
                <td>{{ $subject->practical_full_marks }}</td>
                <td>
                    <input type="text" name="theory_obtained_marks[{{ $subject->id }}]" class="form-control"/>
                </td>
                <td>
                    <input type="text" name="practical_obtained_marks[{{ $subject->id }}]" class="form-control"/>
                </td>
            </tr>
            @endforeach
        @else
            @foreach($subjects as $subject)
            <tr>
                <td>{{ '[ '.$subject->code.'] '.$subject->name }}</td>
                <td>{{ $subject->full_marks }}</td>
                <td>{{ $subject->pass_marks }}</td>
                <td>
                    <input type="text" class="form-control" name="obtained_marks[{{ $subject->id }}]"/>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>