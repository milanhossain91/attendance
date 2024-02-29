@extends('frontend.masterDashboard')
@section('title', 'Shift Add')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Update Shift</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('shift') }}">Shift Manage</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update Shift</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- @if($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif --}}
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle"> ** All field required. </h6>
                        <form class="m-t-30" action="{{ route('shift-update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$result->id}}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Shift Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="shift_name" id="shift_name" placeholder="Enter name" autocomplete="off" value="{{$result->shift_name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Short Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="short_name" id="short_name" placeholder="Enter name" autocomplete="off" value="{{$result->short_name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Start Time <span class="error">*</span></label>
                                <div class='input-group date' id='datetimepicker1'>
                                   <input type="text" class="form-control" name="start_time" id="start_time" placeholder="Enter name" autocomplete="off" value="{{$result->start_time}}" required>
                                   <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                            </div>                            

                            <div class="form-group">
                                <label for="exampleInputEmail1">End Time <span class="error">*</span></label>
                                <input type="text" class="form-control" name="end_time" id="timeEnd" placeholder="Enter name" autocomplete="off" value="{{$result->start_end}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Year & Month <span class="error">*</span></label>
                                <div class='input-group date' id='datetimepicker1'>
                                   <select class="form-control" name="month" required>
                                        @php 
                                        $year = date('Y');
                                        $selectedMonth = $result->roster_year.'-'.$result->roster_month.'-01';
                                        for($i=1;$i<=12;$i++) {                                                         
                                        @endphp
                                        <option value="{{ date("Y-m-01", strtotime("$year-" . $i . "-25")) }}" @if($selectedMonth==date("Y-m-01", strtotime("$year-" . $i . "-25"))) selected @endif>{{ date("F Y", strtotime("$year-" . $i . "-25")) }}</option>

                                        @php 
                                        }
                                        @endphp
                                    </select>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
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