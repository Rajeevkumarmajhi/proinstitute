@extends('layouts.admin')

@section('title', 'Create Menu')

@section('styles')

<style>
    .hide{
        display: none;
    }
    #studentsSection{
        padding-left: 20px;
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
                            <li class="breadcrumb-item active">Create Menu</li>
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
                                <h3 class="card-title">New Student Attendance</h3>
                            </div>


                            <form method="POST" action="{{ route('attendance.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date</label>
                                        <input class="form-control" type="date" name="date" placeholder="Enter Attendance Date">
                                        <input class="hide" type="text" name="user_type" value="Student">
                                    </div> 

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Class</label>
                                        <select class="form-control" name="grade_id" id="grade">
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> 

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Section</label>
                                        <select class="form-control" name="section_id" id="section">
                                        </select>
                                    </div> 
                                </div>

                                <div id="studentsSection"></div>

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
    <input type="hidden" id="getStudentsection" value="{{ route('get.student') }}">
@endsection

@section('scripts')

<script>
    $(function(){

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

            let grade_id = $('#grade').val();
            let section_id = $(this).val()

            let url = $('#getStudentsection').val();

            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: {
                    "grade_id":grade_id,
                    "section_id":section_id,
                    "caller_module":"Attendance",
                },
                beforeSend:function(){
                    console.log('ajax fired');
                },
                success: function (data) {
                    if(data.status==true){
                        console.log(data.status);
                        $('#studentsSection').empty();
                        $('#studentsSection').html(data.view);
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
