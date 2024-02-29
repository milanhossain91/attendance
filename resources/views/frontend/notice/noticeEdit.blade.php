@extends('frontend.masterDashboard')
@section('title', 'Notice Update')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Notice</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Notice</li>
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
                        <form class="m-t-30" action="{{ route('notice-update-submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $result->id }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Notice Title <span class="error">*</span></label>
                                <input type="text" class="form-control" name="notice_title" id="notice_title" value="{{ $result->title }}" placeholder="Notice Title" required>
                                                                
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Notice Details <span class="error">*</span></label>
                                <textarea class="form-control" name="details" placeholder="Notice Details" required>{{ $result->details }}</textarea>                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Expire Date (Default Tomorrow)<span class="error">*</span></label>
                                <input type="text" class="form-control" name="expire_date" id="to" value="{{date('d-m-Y', strtotime($result->expire_date))}}" readonly>                                
                            </div>

                            <div class="form-group has-danger">
                                <label class="control-label">Status <span class="error">*</span></label>
                                <select class="form-control custom-select" name="status_name" id="status_name" required>
                                  <option value="0" @if($result->status==0) selected @endif>Active</option>
                                  <option value="1" @if($result->status==1) selected @endif>Inactive</option>
                                </select>
                                <small class="form-control-feedback"></small> 
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