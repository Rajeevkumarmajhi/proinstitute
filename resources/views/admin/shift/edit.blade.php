@extends('layouts.admin')

@section('title', 'Update Shift')

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Shift</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Shift</li>
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
                                <h3 class="card-title">Update Shift</h3>
                            </div>

                            <form method="POST" action="{{ route('shift.update',[$shift->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                            placeholder="Enter Shift Name" value="{{ $shift->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Start Time</label>
                                        <input type="time" class="form-control" id="exampleInputEmail1" name="start_time"
                                            placeholder="Enter Start Time" value="{{ $shift->start_time }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">End Time</label>
                                        <input type="time" class="form-control" id="exampleInputEmail1" name="end_time"
                                            placeholder="Enter End Time" value="{{ $shift->end_time }}">
                                    </div>
                                    
                                </div>

                                <div class="card-footer">
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