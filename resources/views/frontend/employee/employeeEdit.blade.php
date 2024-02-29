@extends('frontend.masterDashboard')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Employee</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
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
                        <form class="m-t-30" action="{{ route('employee-update-submit') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $result->id }}">
                            <div class="form-body">
                                <div class="card-body">
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name <span class="error">*</span></label>
                                                <input type="text" name="employee_name" id="employee_name" class="form-control" value="{{ $result->name }}" placeholder="Enter Name" required>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone_number" id="phone_number" class="form-control form-control-danger" value="{{ $result->mobile }}" placeholder="Enter Number">
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Department <span class="error">*</span></label>
                                                <select class="form-control custom-select" type="text" name="department_id" id="department_id" placeholder="" required>
                                                    @foreach ($department as $departments)
                                                        <option value="{{ $departments->id }}" @if($departments->id==$result->department_id) selected @endif>{{ $departments->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                           <div class="form-group">
                                                <label class="control-label">Joining Date <span class="error">*</span> </label>
                                                <input type="text" id="to" name="join_date" value="{{ date('d-m-Y',strtotime($result->joining_date)) }}" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Designation <span class="error">*</span></label>
                                                <select class="form-control custom-select" type="text" name="designation_id" id="designation_id" placeholder="" required>
                                                    {{-- <option value="">Please Select</option> --}}
                                                    @foreach ($designation as $designations)
                                                        <option value="{{ $designations->id }}" @if($designations->id==$result->designation_id) selected @endif>{{ $designations->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group has-danger">
                                                <label class="control-label">Approval</label>
                                                <select class="form-control custom-select" name="approval_name" id="approval_name"> 
                                                    <option value="Yes" @if($result->approval=="Yes") selected @endif>Yes</option>
                                                    <option value="No" @if($result->approval=="No") selected @endif>No</option>
                                                </select>
                                                {{-- <input type="text" name="approval_name" id="approval_name" class="form-control form-control-danger" value="{{ $result->approval }}" placeholder=""> --}}
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Shift <span class="error">*</span></label>
                                                <select class="form-control custom-select" type="text" name="shift_id" id="shift_id" placeholder="" required>
                                                    {{-- <option value="">Please Select</option> --}}
                                                    @foreach ($shift as $shifts)
                                                        <option value="{{ $shifts->id }}"  @if($shifts->id==$result->shift_id) selected @endif>{{ $shifts->start_time }} To {{ $shifts->start_end }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Code/Finger Print Id <span class="error"> *</span></label>
                                                <input type="text" name="code_number" id="code_number" value="{{ $result->code }}" class="form-control form-control-danger" placeholder="" required>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-success">
                                                <label class="control-label">Gender <span class="error">*</span></label>
                                                <select class="form-control custom-select" name="gender" id="gender">                                                    
                                                    <option value="Male" @if($result->gender=="male") selected @endif>Male</option>
                                                    <option value="Female"@if($result->gender=="female") selected @endif>Female</option>
                                                </select>
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Date of Birth</label>
                                                <input type="text" id="from" name="birth_date" class="form-control" value="{{ date('d-m-Y',strtotime($result->birth_date)) }}" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                       
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Email <span class="error">*</span></label>
                                                <input type="text" name="email" id="email" value="{{ $result->email }}" class="form-control form-control-danger" placeholder="Enter Email">
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Password </label>
                                                <input type="text" name="password" id="password" class="form-control" value="" placeholder="If need change">
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Salary <span class="error">*</span></label>
                                                <input type="text" name="salary" id="salary" class="form-control form-control-danger" value="{{ $result->salary }}" placeholder="Enter Salary">
                                                <small class="form-control-feedback"></small> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="image" id="" class="form-control">
                                                @if($result->image!='')
                                                <img src="{{ URL::asset('/uploads/users/'.$result->image) }}" width="100px" height="100px" alt="user">
                                                @endif     
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Roster</label>
                                                <select class="form-control" name="roster">
                                                    <option value="No" @if($result->roster=='No') selected @endif>No</option>
                                                    <option value="Yes" @if($result->roster=='Yes') selected @endif>Yes</option>
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