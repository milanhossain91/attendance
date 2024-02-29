@extends('frontend.masterDashboard')
@section('title', 'Adjustment Add')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Add Adjustment</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('adjustment') }}">Adjustment</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Adjustment</li>
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
                        <form class="m-t-30" action="{{ route('adjustment-submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ Auth::user()->name }}" readonly>                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Adjustment Date <span class="error">*</span></label>
                                <input type="text" class="form-control" name="adjustment_date" id="from" placeholder="Adjustment Date" autocomplete="off" required>                                
                            </div>
                            <div class="form-group has-danger">
                                <label class="control-label">Type <span class="error">*</span></label>
                                <select class="form-control custom-select" name="status_type" id="status_type">
                                    <option value="0">Adjustment IN</option>
                                    <option value="1">Adjustment OUT</option>
                                </select>
                                <small class="form-control-feedback"></small> 
                            </div> 
                            <div class="form-group">
                                <label for="exampleInputEmail1">Time <span class="error">*</span></label>
                                <input type="text" class="form-control" name="adjustment_time" id="adjustment_time" placeholder="08:00" maxlength="5" required>                                
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