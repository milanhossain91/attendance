@extends('frontend.masterDashboard')
@section('title', 'Dashboard')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    @include('frontend/middlePageHeading')
    
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <i class="mdi mdi-account-multiple font-20 text-muted"></i>
                                    <p class="font-16 m-b-5">Employee</p>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right">{{ $employeeTotal }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <i class="mdi mdi-collage font-20  text-muted"></i>
                                    <p class="font-16 m-b-5">Department</p>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right">{{ $departmentTotal }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <i class="mdi mdi-account-multiple font-20 text-muted"></i>
                                    <p class="font-16 m-b-5">Today Present</p>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right">{{ $presentToday }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 70%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <i class="mdi mdi-account-multiple font-20 text-muted"></i>
                                    <p class="font-16 m-b-5">Today Absent</p>
                                </div>
                                <div class="ml-auto">
                                    <h1 class="font-light text-right">{{ $absentToday }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 80%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Leaves</h4>
                    </div>
                    <div class="comment-widgets scrollable" style="height:345px;">
                        <!-- Comment Row -->
                        @foreach($result as $leaves)
                        <div class="d-flex flex-row comment-row m-t-0">
                            <div class="p-2">
                                <img src="{{ URL::asset('frontend/assets/images/users/default-user.jpg') }}" alt="user" width="50" class="rounded-circle">
                            </div>
                            <div class="comment-text w-100">
                                <h6 class="font-medium">{{ $leaves->uname }}</h6>
                                <span class="m-b-15 d-block">{{ $leaves->reason }}</span>
                                <div class="comment-footer">
                                    <span class="text-muted float-right">{{ date('d M Y',strtotime($leaves->from_date)) }} To {{ date('d M Y',strtotime($leaves->to_date)) }}</span>
                                    @if($leaves->approved=='No')
                                    <span class="label label-rounded label-primary">Pending</span>
                                    @elseif($leaves->approved=='Approved')
                                    <span class="label label-rounded label-success">Approved</span>
                                    @elseif($leaves->approved=='Rejected')
                                    <span class="label label-rounded label-danger">Rejected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title">Current Year Attendance/Absent</h4>
                            </div>
                        </div>
                        <div class="chart1 m-t-40" style="position: relative; height:250px;"></div>
                        <ul class="list-inline m-t-30 text-center font-12">
                            <li class="list-inline-item text-muted"><i class="fa fa-circle text-info m-r-5"></i> Present</li>
                            <li class="list-inline-item text-muted"><i class="fa fa-circle text-light m-r-5"></i> Absent</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>                
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    @include('/frontend/masterFooter')
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>

@endsection