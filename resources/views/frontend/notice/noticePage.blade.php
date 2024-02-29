@extends('frontend.masterDashboard')
@section('title', 'Notice')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Notice</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Notice</li>
                    </ol>
                </nav>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ route('notice-create') }}">
                        <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add Notice</button>
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
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Notice Heading</th>
                                        <th>Notice Details</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($result as $key => $result)
                                    <tr>
                                        <td width="4%">{{ $key+1 }}</td>
                                        <td width="20%">{{ $result->title }}</td>
                                        <td width="30%">{{ $result->details }}</td>
                                        <td width="10%">
                                            @if($result->status==0)
                                            Active
                                            @else
                                            Inactive
                                            @endif
                                        </td>
                                        <td width="15%">
                                            <a href="{{ route('notice-update',$result->id) }}" title="Edit">
                                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button></a> &nbsp; 
                                            <a href="{{ route('notice-delete',$result->id) }}" title="Delete" onclick="return confirm('Are you sure you want to delete?')">
                                            <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>                                
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

@endsection