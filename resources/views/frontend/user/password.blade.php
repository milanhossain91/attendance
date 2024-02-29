@extends('frontend.masterDashboard')
@section('title', 'Change Password')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Change Password</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
                        @if(session('success'))
                            <p class="alert alert-success">{{ session('success') }}</p>
                        @endif

                        @if($errors->any())
                        @foreach($errors->all() as $err)
                            <p class="alert alert-danger">{{ $err }}</p>
                        @endforeach
                        @endif

                        <form class="form-horizontal m-t-20" action="{{ route('password.action') }}" method="post">
                            @csrf
                            <div class="form-group row ">
                                <div class="col-12 ">
                                    <input class="form-control" type="password" name="old_password" required=" " placeholder="Old Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input class="form-control" type="password" name="new_password" required=" " placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input class="form-control" type="password" name="new_password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class="form-group text-center ">
                                <div class="col-xs-12 p-b-20 ">
                                    <button type="submit" class="btn btn-success m-r-10"><i class="ti-lock m-r-5 m-l-5"></i> Change Password</button>

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