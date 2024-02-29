@extends('frontend.masterDashboard')
@section('title', 'Attendance Information')
@section('content')
<style type="text/css">
    .table td, .table th { padding: 5px !important; }
    .color { background: #ffeeaa; }
    .color2 { background: #ffffaa; }
    .colorRed { color: #FF0000; }
</style>
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Attendance Information</h4>                
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Attendance Information</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('post-employeewise-attendance') }}" method="post">
                            @csrf
                            @php
                            if(isset($start_dt)) {$sdt = $start_dt;}else{$sdt = date('d-m-Y');}
                            if(isset($end_dt)) {$edt = $end_dt;}else{$edt = date('d-m-Y');}
                            foreach($all_employee as $all_emp){
                                if($emp_id==$all_emp->id) $emp_name = $all_emp->name;
                            }
                            @endphp
                            <div class="form-body">
                                <div class="card-body p-0">
                                    <div class="row">
                                        @if(Auth::user()->type=='Admin')
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Department <span class="error">*</span></label>
                                                <select class="form-control" name="dept_id" id="dept_id">
                                                    <option value="">Please Select</option>
                                                    @foreach($all_department as $all_dept)
                                                    <option value="{{$all_dept->id}}" @if($dept_id==$all_dept->id) selected @endif>
                                                        {{ucwords($all_dept->name)}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <small class="form-control-feedback"></small> </div>   
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Employee <span class="error">*</span></label>
                                                <select class="form-control custom-select" name="emp_id" id="emp_id">
                                                    <option value="">Please Select</option>
                                                    @foreach($all_employee as $all_emp)
                                                    <option value="{{$all_emp->code}}" @if($emp_id==$all_emp->code) selected @endif>{{ucwords($all_emp->name)}}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-control-feedback"></small> </div>   
                                        </div>
                                        @elseif(Auth::user()->type=='Head')
                                        <div class="col-md-4">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Employee <span class="error">*</span></label>
                                                <select class="form-control" name="emp_id" id="emp_id">
                                                    <option value="">Please Select</option>
                                                    @foreach($all_employee as $all_emp)
                                                    <option value="{{$all_emp->code}}" @if($emp_id==$all_emp->code) selected @endif>{{ucwords($all_emp->name)}}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-control-feedback"></small>
                                            </div>   
                                        </div>
                                        @else
                                        <div class="col-md-12" id="visible_2">
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                <input type="hidden" name="emp_id" value="{{Auth::user()->employee_id}}" />
                                                </div>   
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-3">
                                              <div class="form-group">
                                                <label class="control-label">From Date <span class="error">*</span> </label>
                                                <input type="text" name="start" id="from" value="{{$sdt}}" class="form-control" autocomplete="off">
                                            </div>      
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">To Date <span class="error">*</span></label>
                                                <input type="text" name="end" id="to" value="{{$edt}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">&nbsp;</label>
                                                <input type="submit" class="form-control btn btn-success" value="Search">
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </form>                      
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>                                   
                                    <tr>                                        
                                        <th class="text-center">Date</th>
                                        <th class="text-center">In Time</th>
                                        <th class="text-center">Out Time</th>
                                        <th class="text-center">Working Hour's</th>
                                        <th class="text-center">Overtime Hour's</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($emp_attendance_date_range as $att)
                                    
                                    @php
                                    $w_hour = Null;
                                    $o_hour = Null;
                                    $x = explode('-',$att->shift_time);
                                    if($x[0]!='00:00')
                                    {
                                        $intime     = '00:00';
                                        $latetime   = '00:00';

                                        $intime     = $att->in_time;
                                        $outtime    = $att->out_time;
                                        $w_hour_cal = intval((strtotime($outtime)-strtotime($intime))/60);

                                        if(($w_hour_cal%60)>0)
                                        {
                                            $w_hour = intval($w_hour_cal/60).' Hours '.($w_hour_cal%60).' Minutes';
                                        }
                                        else
                                        {
                                            $w_hour = intval($w_hour_cal/60).' Hours';
                                        }

                                        $s_start    = $x[0];
                                        $s_end      = $x[1];
                                        $w_shift_cal= intval((strtotime($s_end)-strtotime($s_start))/60);
                                        $o_hour     = '';

                                        if($w_hour_cal>$w_shift_cal)
                                        {
                                            $o_hour_cal = ($w_hour_cal-$w_shift_cal); 
                                            if(($o_hour_cal%60)>0)
                                            {
                                                    $o_hour = intval($o_hour_cal/60).' Hours '.($o_hour_cal%60).' Minutes';
                                            }
                                            else
                                            {
                                                $o_hour = intval($o_hour_cal/60).' Hours';
                                            }
                                        }
                                    }
                                        
                                    @endphp

                                    @if($att->attendance_type=='Weekend')
                                    <tr>       
                                        <td class="color text-center">{{date('d-M-Y',strtotime($att->date))}}</td>
                                        <td class="color text-center"></td>
                                        <td class="color text-center"></td>
                                        <td class="color text-center"></td>
                                        <td class="color text-center"></td>
                                        <td class="color text-center"><strong>
                                            {{date("l", strtotime($att->date))}}</strong></td>
                                    </tr>
                                    @elseif($att->attendance_type=='National Holiday')
                                    <tr>       
                                        <td class="color2 text-center">{{date('d-M-Y',strtotime($att->date))}}</td>
                                        <td class="color2 text-center"></td>
                                        <td class="color2 text-center"></td>
                                        <td class="color2 text-center"></td>
                                        <td class="color2 text-center"></td>
                                        <td class="color2 text-center">
                                            <strong>{{ $att->remarks }}</strong></td>
                                    </tr>
                                    @elseif($att->attendance_type=='Absent')
                                    <tr>       
                                        <td class="text-center">{{date('d-M-Y',strtotime($att->date))}}</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="colorRed text-center">
                                            <strong>{{ $att->attendance_type }}</strong></td>
                                    </tr>
                                    @else                                    
                                    <tr>                                        
                                        <td class="text-center">{{date('d-M-Y',strtotime($att->date))}}</td>
                                        <td class="text-center">{{date("h:i:s", strtotime($att->in_time))}}</td>
                                        <td class="text-center">{{date("h:i:s", strtotime($att->out_time))}}</td>
                                        <td class="text-center">{{$w_hour}}</td>
                                        <td class="text-center">{{$o_hour}}</td>
                                        <td class="text-center">{{$att->attendance_type}}</td>
                                    </tr>
                                    @endif

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

<script src="{{ URL::asset('frontend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script>
	$(document).ready(function(){
		var CSRF_TOKEN 		= $('meta[name="csrf-token"]').attr('content');
		var post_url 		= '{{ url("api/fetch-employee") }}';
		var msg         	= $('.alert-info');
		//$('.btn-info').each(function() {
        $('#dept_id').on('change',function(e){
            var id = this.value;
            $.ajax({
                url: post_url,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, id: id},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                beforeSend: function() {
                    $(msg).html('Please Wait....... Processing').css("display", "block").delay(3000).fadeOut("slow");
                },
                success: function (data) {
                    //console.log(data);
                    $('#emp_id').html('<option value="">Please Select</option>');
                        $.each(data.employees, function (key, value) {
                            $("#emp_id").append('<option value="' + value
                                .code + '">' + value.name + '</option>');
                        });

                    //$(msg).html(data.msg).css("display", "block").delay(3000).fadeOut("slow");
                }
            });
		});
	});
</script>

@endsection