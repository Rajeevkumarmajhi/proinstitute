<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Export Marksheet</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }} ">
</head>
<body>
<div class="wrapper" style="margin: 20px 20px;">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12" style="text-align: center;">
        <h2 class="page-header">
            <h1>{{ $siteSetting->school_name }}</h1> <br/>
            <img style="height:150px;text-align:center;" src="{{ asset($siteSetting->logo) }}" />
            <small class="float-right">Date: {{ date('Y-m-d') }}</small>
            </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>{{ $siteSetting->school_name }}</strong><br>
          {{ $siteSetting->address }}<br>
          Phone: {{ $siteSetting->phone }}<br>
          Email: {{ $siteSetting->email }}
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>{{ $student->name }}</strong><br>
          {{ $student->address }}<br>
          {{ $student->class }}<br>
          {{ $student->section }}<br>
          {{ $student->roll_no }}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
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
            </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead"></p>
        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
        </p>
      </div>
      <!-- /.col -->
      <div class="col-6">

        <div class="table-responsive">
          <table class="table">
            <tr>
                <th style="width:50%">Percentage:</th>
                <td>

                    @if($type=="Yes")
                            <?php 
                                $total_full_marks = $total_theory_full_marks + $total_practical_full_marks;
                                $total_obtained_marks = $total_theory_obtained_marks + $total_practical_obtained_marks;
                                $percentage = $total_obtained_marks/$total_full_marks * 100; 
                            ?>
                            {{ $percentage }} %
                    @else
                            <?php $percentage = $total_obtained_marks/$total_full_marks * 100; ?>
                            {{ $percentage }} %
                    @endif


                </td>
            </tr>
            <tr>
              <th>Grade</th>
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
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    <div class="row">
        <div class="col-6">
            ........................ <br/>
            Class Teacher (signature) <br/>
        </div>
        <div class="col-6" style="float-right">
            ........................ <br/>
            Principal (signature)
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="row">
        <div class="col-12" style="text-align:center;">
            &copy; Matin Softech, Biratnagar - www.matinsoftech.com Phone:9800971310
        </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>