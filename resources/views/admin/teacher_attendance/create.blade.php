@extends('layouts.admin')

@section('title', 'Create Teacher Attendance')

@section('styles')

    <style>
        .hide{
            display: none;
        }
    </style>

@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Teacher Attendance</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Teacher Attendance</li>
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
                                <h3 class="card-title">New Teacher Attendance</h3>
                            </div>


                            <form method="POST" action="{{ route('attendance.store') }}">
                                @csrf

                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date (M/D/Y)</label>
                                        <input class="form-control" type="date" name="date" placeholder="Enter Attendance Date">
                                        <input class="hide" type="text" name="user_type" value="Student">
                                    </div> 

                                </div>


                                <table class="table table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Teacher Name</th>
                                            <th>Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $teacher)
                                        <tr>
                                            <td>{{ $teacher->name }}</td>
                                            <td>
                                                <input type="text" class="hide" name="teacher[{{ $teacher->id }}]">
                                                <input type="checkbox" name="attendance[{{ $teacher->id }}]"/>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="card-footer">
                                    <input class="hide" type="text" name="user_type" value="Teacher">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>
@endsection
