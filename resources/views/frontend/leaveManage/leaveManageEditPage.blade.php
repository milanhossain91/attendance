@extends('frontend.masterDashboard')
@section('title', 'Edit Leave')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Leave</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('leave') }}">Leave Manage</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Leave</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <form action="{{ route('leave-update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$result->id}}">
                        <div class="form-body">
                            <div class="card-body">
                                <h6 class="card-subtitle"> ** All field required. </h6>
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Name </label>
                                            <input type="text" class="form-control" value="{{$result->name}}" readonly>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Date of Application</label>
                                            <input type="text" class="form-control form-control-danger" id="to" value="{{ date('d-m-Y')}}" readonly>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Designation </label>
                                            <input type="text" class="form-control" value="{{$result->desiname}}" readonly>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Employee ID </label>
                                            <input type="text" class="form-control" value="{{$result->code}}" readonly>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Department </label>
                                            <input type="text" class="form-control" value="{{$result->deptname}}" readonly>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Type of leave <span class="error">*</span></label>
                                            <select class="select2 form-control custom-select" style="width: 100%;" name="category_id" required>
                                                <option value="">Select Type of leave</option>
                                                @foreach($leaveType as $type)
                                                <option value="{{ $type->id }}" @if($result->category_id==$type->id) selected @endif>{{ $type->name }}</option>
                                                @endforeach
                                            </select> 
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Leave Period <span class="error">*</span></label>
                                            <input type="text" class="form-control" name="from_date" id="fromDate" value="{{ date('d-m-Y' , strtotime($result->from_date))}}" placeholder="From Date" autocomplete="off" required>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">&nbsp;</label>
                                            <input type="text" class="form-control" name="to_date" id="toDate" value="{{ date('d-m-Y' , strtotime($result->to_date))}}" placeholder="To Date" autocomplete="off" required>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">No of days <span class="error">*</span></label>
                                            <input type="text" class="form-control" name="No_of_days" value="{{$result->No_of_days}}" required>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Reason for leave <span class="error">*</span></label>
                                            <input type="text" class="form-control" name="reason" value="{{$result->reason}}" required>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Address during leave <span class="error">*</span></label>
                                            <input type="text" class="form-control" name="address_during_leave" value="{{$result->address_during_leave}}" required>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Person who will hold charge <span class="error">*</span></label>
                                            <input type="text" class="form-control" name="person_charge" value="{{$result->person_charge}}" required>
                                            <small class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--/row-->
                            </div>
                            <hr>
                            <div class="form-actions">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Leave Submit</button>
                                    <button type="button" onclick="history.back()" class="btn btn-dark">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
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