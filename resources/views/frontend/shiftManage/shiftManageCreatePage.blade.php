@extends('frontend.masterDashboard')
@section('title', 'Shift Add')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Add Shift </h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('shift') }}">Shift Manage</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Shift </li>
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
                        <form class="m-t-30" action="{{ route('shift-submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Shift Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="shift_name" id="shift_name" placeholder="Enter name" autocomplete="off" value="{{ old('shift_name')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Short Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="short_name" id="short_name" placeholder="Enter name" autocomplete="off" value="{{ old('short_name')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Start Time <span class="error">*</span></label>
                                <div class='input-group date' id='datetimepicker1'>
                                   <input type="text" class="form-control" name="start_time" id="start_time" placeholder="Enter name" autocomplete="off" value="{{ old('start_time')}}" required>
                                   <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                            </div>                            

                            <div class="form-group">
                                <label for="exampleInputEmail1">End Time <span class="error">*</span></label>
                                <input type="text" class="form-control" name="end_time" id="timeEnd" placeholder="Enter name" autocomplete="off" value="{{ old('end_time')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Year & Month <span class="error">*</span></label>
                                <div class='input-group date' id='datetimepicker1'>
                                   <select class="form-control" name="month" required>
                                        @php 
                                        $i = 1;
                                        $date = date('Y-01-01');
                                        $month = strtotime($date);
                                        while($i <= 12)
                                        {
                                            $month_name = date('F', $month);
                                            echo '<option value="'. date('Y-m-01', $month). '">'.$month_name.' '.date('Y').'</option>';
                                            $month = strtotime('+1 month', $month);
                                            $i++;
                                        }
                                        @endphp  
                                    </select>
                                </div>
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