@extends('frontend.masterDashboard')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Add Employee</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li> --}}
                        <li class="breadcrumb-item">
                            <a href="{{ route('employee') }}">Employee</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">Other Sample form</h4>
                    </div> --}}
                    <form action="{{ route('employee-submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="card-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Name <span class="error">*</span></label>
                                            <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Enter Name" required>
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control form-control-danger" placeholder="Enter Number">
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Department <span class="error">*</span></label>
                                            <select class="form-control custom-select" type="text" name="department_id" id="department_id" placeholder="" required>
                                                <option value="">Please Select</option>
                                                @foreach ($department as $departments)
                                                    <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="form-control-feedback"></small> </div>
                                       
                                    </div>
                                    <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="control-label">Joining Date <span class="error">*</span> </label>
                                            <input type="text" id="to" name="join_date" class="form-control" autocomplete="off" required>
                                        </div>
                                            
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Designation <span class="error">*</span></label>
                                            <select class="form-control custom-select" type="text" name="designation_id" id="designation_id" placeholder="" required>
                                                <option value="">Please Select</option>
                                                @foreach ($designation as $designations)
                                                    <option value="{{ $designations->id }}">{{ $designations->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="form-control-feedback"></small> </div>
                                            
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Approval</label>
                                            <select class="form-control custom-select" name="approval_name" id="approval_name">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>     
                                            </select>
                                            <small class="form-control-feedback"></small> </div>   
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Shift <span class="error">*</span></label>
                                            <select class="form-control custom-select" type="text" name="shift_id" id="shift_id" placeholder="" required>
                                                <option value="">Please Select</option>
                                                @foreach ($shift as $shifts)
                                                    <option value="{{ $shifts->id }}">{{ $shifts->start_time }} To {{ $shifts->start_end }}</option>
                                                @endforeach 
                                            </select>
                                            <small class="form-control-feedback"></small> </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Code/Finger Print Id <span class="error"> *</span></label>
                                            <input type="text" name="code_number" id="code_number" class="form-control form-control-danger" placeholder="" required>
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-success">
                                            <label class="control-label">Gender <span class="error"> *</span></label>
                                            <select class="form-control custom-select" name="gender" id="gender">
                                                <option value="">Please Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Date of Birth</label>
                                            <input type="text" name="birth_date" id="from" class="form-control" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Email <span class="error">*</span></label>
                                            <input type="text" name="email" id="email" class="form-control form-control-danger" placeholder="Enter Email" required>
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Password <span class="error">*</span></label>
                                            <input type="text" name="password" id="password" class="form-control" placeholder="Enter Password" >
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Salary <span class="error">*</span></label>
                                            <input type="text" name="salary" id="salary" class="form-control form-control-danger" placeholder="Enter Salary">
                                            <small class="form-control-feedback"></small> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-danger">
                                            <label class="control-label">Roster</label>
                                            <select class="form-control" name="roster">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                            </div>
                            <hr>
                            <div class="form-actions">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                    <button type="button" class="btn btn-dark">Cancel</button>
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