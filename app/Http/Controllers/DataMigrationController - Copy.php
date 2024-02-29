<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;

class DataMigrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function attedanceDataMigration()
    {
        $emptys = DB::table('final_attendances')->count();
        
        $logsResult = DB::table('attendance_logs')
        ->select('pin2','att_date',DB::raw('MIN(in_out_time) AS InTime, MAX(in_out_time) AS OutTime'));
        if($emptys==0)
        {
            $logs = $logsResult->where('pin2','67')->groupBy('att_date')->groupBy('pin2')->get(); 
        }
        else
        {
            $logs = $logsResult
            ->whereBetween('att_date', [date('Y-m-d',strtotime("-3 day")), date('Y-m-d')])
            ->groupBy('att_date')
            ->groupBy('pin2')
            ->get(); 
        }                                            

        foreach($logs as $log)
        {
            $exiting = DB::table('final_attendances')->where('emp_id',$log->pin2)
            ->whereDate('date',$log->att_date)            
            ->first();

            if($exiting==Null)
            {
                $empshifts = DB::table('employees')
                ->select('shifts.start_time','shifts.start_end')
                ->leftJoin('shifts','shifts.id','=','employees.shift_id')
                ->where('code',$log->pin2)
                ->first();

                if($empshifts!=Null)
                {
                    $shift_time = $empshifts->start_time.'-'.$empshifts->start_end;
                }
                else
                {
                    $shift_time = Null;
                }

                //Compare
                $inTimeFormat       = $log->att_date.' '.$log->InTime;
                $outTimeFormat      = $log->att_date.' '.$log->OutTime;
                $inShiftFormat      = $log->att_date.' '.$empshifts->start_time.':00';
                $outShiftFormat     = $log->att_date.' '.$empshifts->start_end.':00';

                $inTimeStrtotime    = strtotime($inTimeFormat);
                $outTimeStrtotime   = strtotime($outTimeFormat);
                $inShiftStrtotime   = strtotime($inShiftFormat);
                $outShiftStrtotime  = strtotime($outShiftFormat);

                //'Present','Present & Earlyout','Late & Earlyout','Late','Absent'
                $attendance_type='';
                if($inShiftStrtotime < $inTimeStrtotime && $outShiftStrtotime < $outTimeStrtotime)
                {
                    $attendance_type= 'Late';
                }
                if($inShiftStrtotime < $inTimeStrtotime && $outShiftStrtotime > $outTimeStrtotime)
                {
                    $attendance_type= 'Late & Earlyout';
                }
                if($inShiftStrtotime > $inTimeStrtotime && $outShiftStrtotime < $outTimeStrtotime)
                {
                    $attendance_type= 'Present';
                }
                if($inShiftStrtotime > $inTimeStrtotime && $outShiftStrtotime > $outTimeStrtotime)
                {
                    $attendance_type= 'Present & Earlyout';
                }

                DB::table('final_attendances')->insert([
                    'emp_id'            => $log->pin2,
                    'in_time'           => $log->InTime,
                    'out_time'          => $log->OutTime,
                    'shift_time'        => $shift_time,
                    'attendance_type'   => $attendance_type,
                    'date'              => $log->att_date
                ]);
            }
        }

        return 0;        
    }
}
