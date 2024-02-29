@extends('frontend.masterDashboard')
@section('title', 'Roster Schedule')
@section('content')

<?php $nth_child = date('j',strtotime('first fri of this month'))+1;?>
<style type="text/css">
    .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {}
    .roster-table tr>th,.roster-table tr>td {
        color:#2d3436;
    }

    th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
    }

    th:nth-child(1),td:nth-child(1) 
    {
        background-color: rgba(34,139,34,.5);
        color: #fff;
    }

/*    th:nth-child(7n + <?php echo $nth_child;?>){ background-color: rgba(255,0,0,.5); }*/

    .panel {
        border-radius: 4px;
    }
    label {
        font-weight: 400;
        font-size: 12px!important;
    }

    body {
        min-height: 500px;
    }
    .tableFloatingHeaderOriginal th {
        border-bottom: 1px solid #DDD;
    }
    .selectedRegular {
        min-width: 28px; 
        width:30px !important; 
        height: 30px !important;
        background-color: green; 
        border-radius: 45px; 
        padding: 7px 0px 0px 11px; 
        color: #FFF;
    }
    .selectedDayOff {
        min-width: 28px; 
        width:30px !important; 
        height: 30px !important;
        background-color: #FFA500; 
        border-radius: 45px; 
        padding: 7px 0px 0px 11px; 
        color: #FFF;
    }
</style>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Roster Setup</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('designation') }}">Roster</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Roster Setup</li>
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
                        <div class="col-xs-12">
                            <div class="panel panel-default widget-box">
                                <div class="panel-heading widget-header">
                                    <h4 class="text-center">Duty Roster {{date('F  Y')}}</h4>
                                </div>
                                <div class="panel-body widget-body">
                                    <div class="table-responsive">
                                        <table id="simple-table" class="table  table-bordered table-hover roster-table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="center">Day</th>
                                                    @foreach($r_calendar as $val)
                                                    <th style="background-color:rgba(34,139,34,.5);">{{date('D',$val)}}</th>
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <th class="center">Date</th>
                                                    @foreach($r_calendar as $val)
                                                    <th @if(date('D',$val)=='Fri') style="background-color: rgba(255,0,0,.5)" @endif>{{date('d',$val)}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php //print_r($employees_time);exit;?>
                                                @foreach($employees_time as $j=>$elist)
                                                <tr>
                                                    <th style="color: #fff;">{{ucwords($elist->name)}}</th>
                                                    @php $ss=0;$sd=0;@endphp
                                                    @foreach($elist->calendarval as $k=>$val)
                                                    @php $ss=$k;$sd=$val['rcal'];@endphp
                                                    <th style="">
                                                        @foreach($val['rshift'] as $shift)
                                                        <label @if($shift->id == $val['rrshift'] && $shift->short_name=='D') class="selectedDayOff" @elseif($shift->id == $val['rrshift'] && $shift->short_name!='D') class="selectedRegular" @else style="min-width: 28px; padding: 7px 0px 0px 11px; color: #000;" @endif>
                                                            
                                                                {{$shift->short_name}}

                                                        </label>
                                                        @endforeach
                                                    </th>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.col -->
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
    $(function() {
        $("table").stickyTableHeaders();
    });

    function radio_changed(val){
        // ajax start
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var post_url    = '{{ url("/postajax_set_rschedule") }}';
        var value       = val;
        if($.trim(value) != '') {
            $.ajax({
                url: post_url,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, value: value},
                dataType: 'JSON',
                async: true,
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
            if (data.status == 'failur') {/*statement*/
                } else {
                    $('#status_'+id).html('<span class="label ' +data.class+ '" style="font-size: 11px;">'+data.classval+'</span>');
                    if(data.status == 2)$('#choose_status_'+id).html('');
                }
            }
        });
        }
        // ajax end
    }

    function rosterReset(id)
    {
        var x = id.split(':');
        var ele = document.getElementsByName("shiftno_"+x[0]);
        for(var i=0;i<ele.length;i++){
            ele[i].checked = false;
        }

        // Funcation call here
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var post_url    = '{{ url("/postajax_reset_roster") }}';
        var value       = id;
        if($.trim(value) != '') {
            $.ajax({
                url: post_url,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, value: value},
                dataType: 'JSON',
                async: true,
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    //alert(data);
                    //toastr()->success('Data has been reset successfully!');
                }
            });
        }
    }
</script>

@endsection