@extends('layouts.admin')

@section('title', 'Update Student')

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<style>
    .select2-selection--single{
        height: 40px!important;
    }
</style>
@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Student</li>
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
                                <h3 class="card-title">New Student</h3>
                            </div>


                            <form method="POST" action="{{ route('user.update',[$user->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                            placeholder="Enter Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="phone"
                                            placeholder="Enter Phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="address"
                                            placeholder="Enter Address">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Father's Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="father_name"
                                            placeholder="Enter Father's Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mother's Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="mother_name"
                                            placeholder="Enter Father's Name">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Gender</label>
                                        <select name="gender" class="form-control">
                                            <option>Select Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date of Birth</label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" name="dob"
                                            placeholder="Enter Date of Birth">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option>Active</option>
                                            <option>Disabled</option>
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

@section('scripts')
<script src="{{ asset('plugins/select2/js/select2.min.js')}}"></script>
<script>
    $(function(){
        $('.select2').select2();
    });
</script>
@endsection