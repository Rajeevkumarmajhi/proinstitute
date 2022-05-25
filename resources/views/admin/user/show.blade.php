@extends('layouts.admin')

@section('title', 'Student Details')

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Student Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Student Details</h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>{{ $user->name }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Roll No</td>
                                            <td>{{ $user->roll_no }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{ $user->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td>{{ $user->dob }}</td>
                                        </tr>
                                        <tr>
                                            <td>Father's Name</td>
                                            <td>{{ $user->father_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother's Name</td>
                                            <td>{{ $user->mother_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $user->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{ $user->phone }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card-title"><h3>Student Courses</h3></div>
                        <table class="table table-hovered table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Fees</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userCourses as $userCourse)
                                <tr>
                                    <td>{{ $userCourse->course->name }}</td>
                                    <td>{{ $userCourse->fees }}</td>
                                    <td>{{ $userCourse->status }}</td>
                                    <td><a href="{{ route('user-course.edit',[$userCourse->id]) }}"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </section>
    </div>
@endsection

@section('scripts')
<script>
    $(function(){

       console.log('ok');
    });
</script>
@endsection