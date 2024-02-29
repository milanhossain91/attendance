@extends('frontend.masterDashboard')
@section('title', 'Shift Manage')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Shift Manage</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Shift Manage</li>
                    </ol>
                </nav>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ route('shift-create') }}">
                        <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add Shift</button>
                    </a>
                </div>
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
                                        {{-- <th>#</th> --}}
                                        <th>Shift Name</th>
                                        <th>Short Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
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
        var table = $('#zero_config1').DataTable({
            destroy: true,
            scrollCollapse: true,
            scrollY: 700, 
            "order": [[1, 'asc']],           
            "ajax": {
                method: "GET",
                url: '{{ URL('shift-result') }}',
                data: {},
                dataType: 'json',                
            },
            "columns": [
                {'data':'shift_name', "width": "100px"},
                {'data':'short_name', "width": "100px"},
                {'data':'start_time', "width": "100px"},
                {'data':'start_end', "width": "100px"},              
                {"data": "Link", "width": "100px",
                    "mRender": function (data, type, full) {                       
                        return '<center><a href="{{ URL('shift-edit')}}/'+(full.id)+'" text-align: center;"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button></a>&nbsp;&nbsp; <a href="{{ URL('shift-delete')}}/'+(full.id)+'" onclick="return DeleteFunction()" text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></a></center>';
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
</script>

@endsection