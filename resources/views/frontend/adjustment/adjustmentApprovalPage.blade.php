@extends('frontend.masterDashboard')
@section('title', 'Adjustment')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Adjustment Approval</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Adjustment Approval</li>
                    </ol>
                </nav>
            </div>
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
                                        <th>Apply By</th>
                                        <th>Adjustment Date</th>
                                        <th>Type</th>
                                        <th>Time</th>
                                        <th class="text-center">Action</th>
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
            "order": [[1, 'asc']],           
            "ajax": {
                method: "GET",
                url: '{{ URL('adjustment-approval-result') }}',
                data: {},
                dataType: 'json',                
            },
            "columns": [            
                {'data':'name'},            
                {'data':'adjustment_date', render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )},            
                {'data':'status',
                    "mRender": function (data, type, full) {

                        if(full.status==1)
                        {
                            return 'IN';
                        }
                        else
                        {
                            return 'OUT';
                        }
                    }
                },            
                {'data':'time'},            
                {"data": "Link", "width":"20%",
                    "mRender": function (data, type, full) {

                        if(full.approval=='Approved')
                        {
                            return '<center style="background: green; color: #FFF;">Approved</center>';
                        }
                        else if(full.approval=='Rejected')
                        {
                            return '<center style="background: red; color: #FFF;">Rejected</center>';
                        }
                        else
                        {
                            return '<center><a href="{{ URL('adjustment-approved/Approved/')}}/'+(full.id)+'" onclick="return ApprovalFunction()" text-align: center;"><button type="button" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approved </button></a>&nbsp;&nbsp; <a href="{{ URL('adjustment-approved/Rejected/')}}/'+(full.id)+'" onclick="return ApprovalFunction()" text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Reject</button></a></center>';                            
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