<table class="table table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            @if($type == "Yes")
            <th>Subjects</th>
            <th>Th Full Marks</th>
            <th>Th Pass Marks</th>
            <th>Pr Full Marks</th>
            <th>Pr Pass Marks</th>
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
            <?php $total_theory_full_marks = 0; ?>
            <?php $total_theory_pass_marks = 0; ?>
            <?php $total_practical_full_marks = 0; ?>
            <?php $total_practical_pass_marks = 0; ?>
            <?php $total_theory_obtained_marks = 0; ?>
            <?php $total_practical_obtained_marks = 0; ?>
            @foreach($subjects as $subject)
            <tr>
                <td>{{ '[ '.$subject->code.'] '.$subject->name }}</td>
                <td>{{ $subject->theory_full_marks }} <?php $total_theory_full_marks = $total_theory_full_marks + $subject->theory_full_marks; ?></td>
                <td>{{ $subject->theory_pass_marks }} <?php $total_theory_pass_marks = $total_theory_pass_marks + $subject->theory_pass_marks; ?></td>
                <td>{{ $subject->practical_full_marks }} <?php $total_practical_full_marks = $total_practical_full_marks + $subject->practical_full_marks; ?></td>
                <td>{{ $subject->practical_pass_marks }} <?php $total_practical_pass_marks = $total_practical_pass_marks + $subject->practical_pass_marks; ?></td>
                <td>{{ $subject->theory_obtained_marks }} <?php $total_theory_obtained_marks = $total_theory_obtained_marks + $subject->theory_obtained_marks; ?></td>
                <td>{{ $subject->practical_obtained_marks }} <?php $total_practical_obtained_marks = $total_practical_obtained_marks + $subject->practical_obtained_marks; ?></td> 
            </tr>
            @endforeach
        @else
            <?php $total_full_marks = 0; ?>
            <?php $total_pass_marks = 0; ?>
            <?php $total_obtained_marks = 0; ?>
            @foreach($subjects as $subject)
            <tr>
                <td>{{ '[ '.$subject->code.'] '.$subject->name }}</td>
                <td>{{ $subject->full_marks }}  <?php $total_full_marks = $total_full_marks + $subject->full_marks; ?> </td>
                <td>{{ $subject->pass_marks }}  <?php $total_pass_marks = $total_pass_marks + $subject->pass_marks; ?></td>
                <td>
                    {{ $subject->obtained_marks }} <?php $total_obtained_marks = $total_obtained_marks + $subject->obtained_marks; ?>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            @if($type=="Yes")
                <td>Total</td>
                <td>{{ $total_theory_full_marks }}</td>
                <td>{{ $total_theory_pass_marks }}</td>
                <td>{{ $total_practical_full_marks }}</td>
                <td>{{ $total_practical_pass_marks }}</td>
                <td>{{ $total_theory_obtained_marks }}</td>
                <td>{{ $total_practical_obtained_marks }}</td>
            @else
                <td>Total</td>
                <td>{{ $total_full_marks }}</td>
                <td> {{ $total_pass_marks }}</td>
                <td> {{ $total_obtained_marks }} </td>
            @endif
        </tr>
        <tr>
            @if($type=="Yes")
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Percentage</td>
                <td>
                    <?php 
                        $total_full_marks = $total_theory_full_marks + $total_practical_full_marks;
                        $total_obtained_marks = $total_theory_obtained_marks + $total_practical_obtained_marks;
                         $percentage = $total_obtained_marks/$total_full_marks * 100; 
                    ?>
                    {{ $percentage }} %
                </td>
            @else
                <td></td>
                <td></td>
                <td> Percentage</td>
                <td> 
                    <?php $percentage = $total_obtained_marks/$total_full_marks * 100; ?>
                    {{ $percentage }} %
                </td>
            @endif
        </tr>
        <tr>
            @if($type=="Yes")
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Grade</td>
                <td>
                    <?php

                    $grade = "F";

                    if( $percentage >= 90){
                        $grade = "A+";
                    }elseif($percentage >= 80){
                        $grade = "A";
                    }elseif($percentage >= 70){
                        $grade = "B+";
                    }elseif($percentage >= 60){
                        $grade = "B";
                    }elseif($percentage >= 50){
                        $grade = "C+";
                    }elseif($percentage >= 40){
                        $grade = "C";
                    }elseif($percentage >= 32){
                        $grade = "D";
                    }else{
                        $grade = "F";
                    }
                    ?>
                    {{ $grade }}

                </td>
            @else
                <td></td>
                <td></td>
                <td> Grade </td>
                <td>
                    <?php

                    $grade = "F";

                    if( $percentage >= 90){
                        $grade = "A+";
                    }elseif($percentage >= 80){
                        $grade = "A";
                    }elseif($percentage >= 70){
                        $grade = "B+";
                    }elseif($percentage >= 60){
                        $grade = "B";
                    }elseif($percentage >= 50){
                        $grade = "C+";
                    }elseif($percentage >= 40){
                        $grade = "C";
                    }elseif($percentage >= 32){
                        $grade = "D";
                    }else{
                        $grade = "F";
                    }
                    ?>
                    {{ $grade }}
                </td>
            @endif
        </tr>
    </tfoot>
</table>