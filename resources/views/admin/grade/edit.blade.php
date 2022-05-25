@extends('layouts.admin')

@section('title', 'Update Grade')

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Class</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Class</li>
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
                                <h3 class="card-title">Update Class</h3>
                            </div>


                            <form method="POST" action="{{ route('grade.update',[$grade->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                            placeholder="Enter Name" value="{{ $grade->name }}">
                                    </div>
                                    
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Symbol</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="symbol"
                                            placeholder="Enter Symbol" value="{{ $grade->symbol }}">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Sections</label>
                                        <?php $sections = json_decode($grade->sections); ?>
                                        <select name="sections[]" class="select2 form-control" multiple>
                                            @if(count($sections)>0)
                                                @foreach ($sections as $item)
                                                    <option selected="selected">{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subjects</label>
                                        <select name="subjects[]" class="select2 form-control" multiple>
                                            @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">[ {{ $subject->code }}] {{ $subject->name }}</option>
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

        $('.select2').select2({
            tags:true,
        });

    });
</script>

@endsection