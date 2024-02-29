@extends('frontend.masterDashboard')
@section('title', 'Leave Type Update')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Update Leave Type</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('leave-type') }}">Leave Type</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update Leave Type</li>
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
                        <form class="m-t-30" action="{{ route('leave-type-edit-submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$result->id}}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Leave Type Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter name" value="{{$result->name}}" required>                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Days</label>
                                <input type="number" class="form-control" name="days" id="days" value="{{$result->days}}" placeholder="0">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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