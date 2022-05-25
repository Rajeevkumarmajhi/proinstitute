@extends('layouts.admin')

@section('title', 'Create Subject')

@section('content')

    <div class="content-wrapper" style="min-height: 1345.6px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Subject</li>
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
                                <h3 class="card-title">New Subject</h3>
                            </div>


                            <form method="POST" action="{{ route('subject.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="name"
                                            placeholder="Enter Name" value="{{ $subject->name }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="code"
                                            placeholder="Enter Code" value="{{ $subject->code }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Optional Subject</label>
                                        <select class="form-control" name="optional" id="">
                                            <option @if($subject->optional=="No") selected="selected" @endif>No</option>
                                            <option @if($subject->optional=="Yes") selected="selected" @endif>Yes</option>
                                        </select>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="exampleInputEmail1">Theory Practical System</label>
                                        <select class="form-control" name="theory_practical" id="tpsys">
                                            <option @if($subject->optional=="No") selected="selected" @endif>No</option>
                                            <option @if($subject->optional=="Yes") selected="selected" @endif>Yes</option>
                                        </select>
                                    </div> --}}

                                    @if($subject->theory_practical=="No")
                                    <div id="theoryPracticalSection">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Full Marks</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="full_marks"
                                                placeholder="Enter Full Marks" value="{{ $subject->full_marks }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Pass Marks</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="pass_marks"
                                                placeholder="Enter Pass Marks" value="{{ $subject->pass_marks }}">
                                        </div>
                                    </div>
                                    @else
                                    <div id="theoryPracticalSection">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Theory Full Marks</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="theory_full_marks"
                                                placeholder="Enter Theory Full Marks" value="{{ $subject->theory_full_marks }}">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Theory Pass Marks</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="theory_pass_marks"
                                                placeholder="Enter Theory Pass Marks" value="{{ $subject->theory_pass_marks }}">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Practical FUll Marks</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="practical_full_marks"
                                                placeholder="Enter Theory Pass Marks" value="{{ $subject->practical_full_marks }}">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Practical Pass Marks</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="practical_pass_marks"
                                                placeholder="Enter Theory Pass Marks" value="{{ $subject->practical_pass_marks }}">
                                        </div>

                                    </div>
                                    @endif
                                    
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

    <input type="hidden" id="getTheoryPracticalsection" value="{{ route('theory.practical') }}">
@endsection

@section('scripts')
<script>
    $(function(){

        $('#tpsys').on('change',function(){

            let theory_practical = $(this).val();

            let url = $('#getTheoryPracticalsection').val();

            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: {
                    "theory_practical":theory_practical
                },
                beforeSend:function(){
                    console.log('ajax fired');
                },
                success: function (data) {
                    if(data.status==true){
                        console.log(data.status);
                        $('#theoryPracticalSection').html(data.view);
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

    });
</script>
@endsection
