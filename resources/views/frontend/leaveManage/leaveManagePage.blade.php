@extends('frontend.masterDashboard')
@section('title', 'Leave Manage')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Leave Manage</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Leave Manage</li>
                    </ol>
                </nav>
            </div>
            @if(Auth::user()->type!='Admin')
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ route('leave-create') }}">
                        <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add Leave</button>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
    

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="zero_config1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Reason</th>
                                        <th>Apply By</th>
                                        <th>Approved By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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

<script type="text/javascript">
    function pageWiseDataLoad()
    {
        var userType = $("#userType").val();
        var table = $('#zero_config1').DataTable({
            destroy: true,
            scrollCollapse: true,
            scrollY: 700, 
            "order": [[1, 'desc']],           
            "ajax": {
                method: "GET",
                url: '{{ URL('leave-result') }}',
                data: {},
                dataType: 'json',                
            },
            "columns": [            
                {'data':'cname'},            
                {'data':'from_date', render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )},            
                {'data':'to_date', render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )},            
                {'data':'reason'},            
                {'data':'uname'},            
                {'data':'aname'},            
                {"data": "Link", "width":"20%",
                    "mRender": function (data, type, full) {

                        if(full.approved=='Approved')
                        {
                            return '<center style="background: green; color: #FFF;">Approved</center>';
                        }
                        else if(full.approved=='Rejected')
                        {
                            return '<center style="background: red; color: #FFF;">Rejected</center>';
                        }
                        else
                        {
                            if(userType!='Admin')
                            {
                                return '<center><a href="{{ URL('leave-edit')}}/'+(full.id)+'" text-align: center;"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button></a>&nbsp;&nbsp; <a href="{{ URL('leave-delete')}}/'+(full.id)+'" onclick="return DeleteFunction()" text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></a></center>';
                            }
                            else
                            {
                                
                                return '<center><a href="{{ URL('leave-approved/Approved/')}}/'+(full.id)+'" onclick="return ApprovalFunction()" text-align: center;"><button type="button" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approved</button></a>&nbsp;&nbsp; <a href="{{ URL('leave-approved/Rejected/')}}/'+(full.id)+'" onclick="return ApprovalFunction()" text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Reject</button></a></center>';


                                // return '<center><a href="{{ URL('leave-delete')}}/'+(full.id)+'" onclick="return DeleteFunction()" text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></a></center>';
                            }                            
                        }
                    }
                }
            ]            
        });
    }

    function DeleteFunction() {
        if (confirm('Are you sure you want to delete this?'))
            return true;
        else {
            return false;
        }
    }

    function ApprovalFunction() {
        if (confirm('Are you sure you want to do this?'))
            return true;
        else {
            return false;
        }
    }
</script>
@endsection