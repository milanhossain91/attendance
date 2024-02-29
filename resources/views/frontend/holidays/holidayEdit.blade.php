@extends('frontend.masterDashboard')
@section('title', 'Holidays Update')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Holiday</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Holiday</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle"> ** All field required. </h6>
                        <form class="m-t-30" action="{{ route('holidays-update-submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $result->id }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Holiday Name</label>
                                <input type="text" class="form-control" name="holiday_name" id="holiday_name" value="{{ $result->name }}" placeholder="Enter name" required>                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="text" class="form-control" name="holiday_date" id="from" value="{{ date('d-m-Y',strtotime($result->date)) }}" placeholder="Enter date" required>                                
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    @include('/frontend/masterFooter')
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>

@endsection