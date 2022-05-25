@extends('layouts.admin')

@section('title', 'Create Student Course')

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
                        <h1>Create Student Course</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Student Course</li>
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

                            <span class="alert alert-danger">{{ session()->get('message') }}</span>

                        @endif
                    </div>

                    <div class="col-md-12">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">New Student Course</h3>
                            </div>


                            <form method="POST" action="{{ route('user-course.update',[$userCourse->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Student</label>
                                        {{ $userCourse->user->name }}
                                        <a href="{{ route('bill.generate',[$userCourse->id]) }}" class="btn btn-primary float-right">Generate Bill</a>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Course</label>
                                        {{ $userCourse->course->name }}
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Total Course Fees</label>
                                        {{ $userCourse->fees }}
                                    </div>

                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>Payment Amount</th>
                                            <th>Due</th>
                                            <th>Payment Date</th>
                                            <th>Due Date</th>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentTransactions as $paymentTransaction)
                                            <tr>
                                                <td>{{ $paymentTransaction->paid_amount }}</td>
                                                <td>{{ $paymentTransaction->due_amount }}</td>
                                                <td>{{ \Carbon\Carbon::parse($paymentTransaction->created_at)->format('jS M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($paymentTransaction->due_date)->format('jS M Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @if($userCourse->status=="Running")
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Add New Payment</label>
                                        <input type="number" name="paid_amount" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Due Date</label>
                                        <input type="date" name="due_date" class="form-control" />
                                    </div>
                                    @endif
                                    
                                </div>

                                @if($userCourse->status=="Running")
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                                @endif
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

        $('#courseId').on('change',function(){
            let fees = $(this).find(':selected').data('fees');
            $('#course_fee').html("Course Fee: "+fees);
            $('#fees_amount').val(fees);
        });

        $('#courseId').change();
    });
</script>
@endsection