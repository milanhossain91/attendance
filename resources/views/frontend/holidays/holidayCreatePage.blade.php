@extends('frontend.masterDashboard')
@section('title', 'Holidays Add')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Add Holiday</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li> --}}
                        <li class="breadcrumb-item">
                            <a href="{{ route('holidays') }}">Holiday</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Holiday</li>
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
                        <form class="m-t-30" action="{{ route('holidays-submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Holiday Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="holiday_name" id="holiday_name" placeholder="Enter name" required>                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Day <span class="error">*</span></label>
                                <input type="text" class="form-control" name="holiday_date" id="from" placeholder="Enter day" required>                                
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