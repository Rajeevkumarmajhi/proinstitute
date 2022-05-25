@extends('layouts.admin')

@section('title', 'Create Notice')

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create notice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create notice</li>
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
                                <h3 class="card-title">New Notice</h3>
                            </div>


                            <form method="POST" action="{{ route('notice.update',[$notice->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Notice</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="title"
                                            placeholder="Enter Notice" value="{{ $notice->title }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Detail</label>
                                        <textarea class="form-control" name="detail" id="" cols="30" rows="10">{{ $notice->detail }}</textarea>
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