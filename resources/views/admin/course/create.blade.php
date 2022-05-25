@extends('layouts.admin')

@section('title', 'Create Course')

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
                        <h1>Create Course</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Course</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                        @endif
                        @if(session()->has('message'))
                        <span class="alert alert-danger">{!! session()->get('message') !!}</span>
                        @endif
                    </div>

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">New Course</h3>
                            </div>


                            <form method="POST" action="{{ route('course.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                            placeholder="Enter Name">
                                    </div>
                                    
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Duration</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="duration"
                                            placeholder="Enter Duration">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Fees</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1" name="fees"
                                            placeholder="Enter Fees">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Shifts</label>
                                        <select name="shifts[]" class="select2 form-control" multiple>
                                            @foreach($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                            @endforeach
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
