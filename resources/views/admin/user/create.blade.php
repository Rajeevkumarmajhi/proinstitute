@extends('layouts.admin')

@section('title', 'Create Student')

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
                        <h1>Create Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Student</li>
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


                            <form method="POST" action="{{ route('user.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">First Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="first_name"
                                                    placeholder="Enter Name">
                                            </div>
    
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Middle Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="middle_name"
                                                    placeholder="Middle Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Last Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="last_name"
                                                    placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Father's First Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="father_first_name"
                                                    placeholder="Enter Father's First Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Father's Middle Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="father_middle_name"
                                                    placeholder="Enter Father's Middle Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Father's Last Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="father_last_name"
                                                    placeholder="Enter Father's Last Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mobile No.</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="mobile_no"
                                                    placeholder="Enter Mobile Number">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Telephone No.</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="telephone_no"
                                                    placeholder="Enter Telephone Number">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Address</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="address"
                                                    placeholder="Enter Address">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Gender</label>
                                                <select name="gender" class="form-control">
                                                    <option>Select Gender</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Date of Birth</label>
                                                <input type="date" class="form-control" id="exampleInputEmail1" name="dob"
                                                    placeholder="Enter Date of Birth">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Status</label>
                                                <select name="status" id="" class="form-control">
                                                    <option>Active</option>
                                                    <option>Disabled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>Course Details</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Desire Subject</label>
                                                <select name="course_id" id="courseID" class="form-control" required>
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Available Shifts</label>
                                                <select name="shift_id" id="shiftID" class="form-control" required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Fees</label>
                                                <input type="number" name="fees" id="fees" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Paid Amount</label>
                                                <input type="number" name="paid_amount" id="paidAmount" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Due Date</label>
                                                <input type="date" name="due_date"  class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Starting Date</label>
                                                <input type="date" name="start_date"  class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Complication Date</label>
                                                <input type="date" name="complication_date"  class="form-control" required>
                                            </div>
                                        </div>
                                        
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

        $('#courseID').on('change',function(){
            let course_id = $(this).val();
            let url = "{{ route('course.shifts') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: {
                    "course_id":course_id
                },
                beforeSend:function(){
                    console.log('ajax fired');
                },
                success: function (data) {
                    if(data.status==true){
                        $('#shiftID').html(data.data);
                        $('#fees').val(data.course.fees);
                        $('.select2').select2();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href>Why do I have this issue?</a>'
                        });
                    }
                },
                error:function(xhr){
                    console.log('500 internal server error');
                    var i = 0;
                    $('.help-block').remove();
                    $('.has-error').removeClass('has-error');
                    for (var error in xhr.responseJSON.errors) {
                        if (i == 0) {
                            $('#add_' + error).focus();
                        }
                        $('#add_' + error).removeClass('has-error');
                        $('#add_' + error).addClass('has-error');
                        $('#add_' + error).closest("div").find('span').first().html('<span class="help-block ' + error + '">*' + xhr.responseJSON.errors[error] + '</span>');
                        i++;
                    }
                }
            });
        });

        $('#courseID').change();
    });
</script>
@endsection