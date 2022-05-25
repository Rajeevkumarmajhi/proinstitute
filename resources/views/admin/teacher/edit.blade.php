@extends('layouts.admin')

@section('title', 'Update Teacher')

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Teacher</li>
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
                                <h3 class="card-title">New Teacher</h3>
                            </div>


                            <form method="POST" action="{{ route('teacher.update',[$user->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                            placeholder="Enter Name" value="{{ $user->name }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="phone"
                                            placeholder="Enter Phone" value="{{ $user->phone }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="address"
                                            placeholder="Enter Address" value="{{ $user->address }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Gender</label>
                                        <select name="gender" class="form-control">
                                            <option>Select Gender</option>
                                            <option @if($user->gender=="Male") selected="selected"  @endif >Male</option>
                                            <option @if($user->gender=="Female") selected="selected"  @endif >Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option @if($user->status=="Active") selected="selected"  @endif >Active</option>
                                            <option @if($user->status=="Disabled") selected="selected"  @endif >Disabled</option>
                                        </select>
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