@extends('layouts.admin')

@section('title', 'Create Result')

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<style>
    .select2-container .select2-selection--single{
        height: 40px;
    }
</style>
@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Menu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Result</li>
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
                                <h3 class="card-title">New Result</h3>
                            </div>


                            <form method="POST" action="{{ route('result.store') }}">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Terminals</label>
                                        <select name="terminal_id" id="terminal_id" class="form-control select2">
                                            @foreach($terminals as $terminal)
                                                <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Grade</label>
                                        <select name="class_id" id="grade" class="form-control select2">
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Section</label>
                                        <select name="section_id" id="section" class="form-control select2"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Student</label>
                                        <select name="user_id" id="student" class="form-control select2">
                                            
                                        </select>
                                    </div>

                                    <div id="subjectView"></div>

                                    
                                    
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

    function getResultSubjects(url,grade_id){

        let user_id = $('#student').val();

        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: {
                "user_id":user_id,
                "grade_id":grade_id
            },
            beforeSend:function(){
                console.log('ajax fired');
            },
            success: function (data) {
                if(data.status==true){
                    $('#subjectView').html(data.subjectView);
                }
            },
            error:function(xhr){
                console.log('500 internal server error');
                var i = 0;
                $('.help-block').remove();
                $('.has-error').removeClass('has-error');
                for (var error in xhr.responseJSON.errors) {
                    console.log(error);
                }
            }
        });

    }

    $('#grade').on('change',function(){

        let url = "{{ route('get.section') }}";
        let grade_id = $(this).val();
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "POST",
            data: {
                "grade_id":grade_id
            },
            beforeSend:function(){
                console.log('ajax fired');
            },
            success: function (data) {
                if(data.status==true){
                    console.log(data.status);
                    $('#section').empty();
                    $.each(data.sections,function(k,v){
                        $("#section").append('<option value="' + v.id + '">' + v.name + '</option>');
                    });

                    $('#section').change();

                    $('#subjectView').html(data.subjectView);
                    setTimeout(() => {
                        getResultSubjects(url,grade_id);
                    }, 1000);

                }
            },
            error:function(xhr){
                console.log('500 internal server error');
                var i = 0;
                $('.help-block').remove();
                $('.has-error').removeClass('has-error');
                for (var error in xhr.responseJSON.errors) {
                    console.log(error);
                }
            }
        });

    });

    $('#section').on('change',function(){

        let url = "{{ route('get.student') }}";
        let section_id = $(this).val();
        let grade_id = $('#grade').val();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: {
                    "grade_id":grade_id,
                    "section_id":section_id
                },
                beforeSend:function(){
                    console.log('ajax fired');
                },
                success: function (data) {
                    if(data.status==true){
                        console.log(data.status);
                        $('#student').empty();
                        $.each(data.students,function(k,v){
                            $("#student").append('<option value="' + v.id + '">' + v.name + '</option>');
                        });

                    }
                },
                error:function(xhr){
                    console.log('500 internal server error');
                    var i = 0;
                    $('.help-block').remove();
                    $('.has-error').removeClass('has-error');
                    for (var error in xhr.responseJSON.errors) {
                        console.log(error);
                }
            }
        });
    });

    $('#grade').change();


});
</script>
@endsection