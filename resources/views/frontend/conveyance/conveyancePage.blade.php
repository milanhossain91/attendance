@extends('frontend.masterDashboard')
@section('title', 'Conveyance Bill')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Conveyance Bill</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Conveyance Bill</li>
                    </ol>
                </nav>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ route('conveyances-create') }}">
                        <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add Conveyance Bill</button>
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
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Assigned Person</th>
                                        <th>Total Amount</th>
                                        {{-- <th>Waiting</th> --}}
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
            "deferRender": true,
            scrollY: 700, 
            "order": [[1, 'asc']],           
            "ajax": {
                method: "GET",
                url: '{{ URL('conveyances-result') }}',
                data: {},
                dataType: 'json',                
            },
            "columns": [
                {'data':'created_at', render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )},
                {'data':'name_of_the_projects'},           
                {'data':'assigned_person'},           
                {'data':'total_amount'},           
                // {'data':'Null'},                       
                {"data": "Link", "width": "20%",
                    "mRender": function (data, type, full) {                       
                        return '<center><a href="{{ URL('conveyances-update')}}/'+(full.id)+'" text-align: center;"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button></a>&nbsp;&nbsp; <a href="{{ URL('conveyances-delete')}}/'+(full.id)+'" onclick="return DeleteFunction()" text-align: center;"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></a></center>';
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