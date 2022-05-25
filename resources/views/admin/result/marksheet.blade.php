@extends('layouts.admin')

@section('title', 'Generate Marksheet')

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
                        <h1>Generate Marksheet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Generate Marksheet</li>
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
                                <h3 class="card-title">Generate Marksheet</h3>
                            </div>

                            <form id="generateMarksheet" method="POST" action="{{ route('marksheet.exportPrint') }}">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Grade</label>
                                        <select name="grade_id" id="grade" class="form-control select2">
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Terminals</label>
                                        <select name="terminal_id" id="terminal" class="form-control select2">
                                            @foreach($terminals as $terminal)
                                                <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Section</label>
                                        <select name="section_id" id="section" class="form-control select2"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Student</label>
                                        <select name="student_id" id="student" class="form-control select2">
                                        </select>
                                    </div>

                                    <div id="marksheetView"></div>

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Print</button>
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
                "grade_id":grade_id,
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

                        $('#student').change();

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

    $('#student').on('change',function(){

        let url = "{{ route('generate.marksheet') }}";
        let student_id = $(this).val();
        let section_id = $('#section').val();
        let grade_id = $('#grade').val();
        let terminal_id = $('#terminal').val();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: {
                    "grade_id":grade_id,
                    "section_id":section_id,
                    "student_id":student_id,
                    "terminal_id":terminal_id
                },
                beforeSend:function(){
                    console.log('ajax fired');
                },
                success: function (data) {
                    if(data.status==true){
                        
                        $('#marksheetView').html(data.view);

                    }else{
                        $('#marksheetView').html('<span class="badge badge-danger">No result found</span>')
                    }
                },
                error:function(xhr){
                    $('#marksheetView').html('<span class="badge badge-danger">No result found</span>')
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