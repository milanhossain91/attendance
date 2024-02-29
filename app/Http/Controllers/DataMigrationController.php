<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DataMigrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function attedanceDataMigration()
    {
        $emptys = DB::table('final_attendances')->count();

        $logsResult = DB::table('attendance_logs');        
        $logsAtt    = $logsResult->whereBetween('att_date',['2022-11-01','2022-11-31'])
        ->groupBy(DB::raw("MONTH(att_date)"))
        ->get();

        foreach($logsAtt as $data)
        {
            $day_count  = date('t', strtotime($data->att_date));
            $month      = date('m', strtotime($data->att_date));
            $year       = date('Y', strtotime($data->att_date));

            for($i = 1; $i<=$day_count; $i++) 
            {   
                $att_date   = date('Y-m-d',strtotime("$month/$i/$year"));
                $start_date = date('Y-m-d',strtotime("$month/$i/$year"));
                $end_date   = date('Y-m-t',strtotime("$month/$i/$year"));

                // Attendance found.
                $logs = DB::table('attendance_logs')
                ->select('pin2','att_date',DB::raw('MIN(in_out_time) AS InTime, MAX(in_out_time) AS OutTime'))
                ->whereBetween('att_date',['2022-11-01','2022-11-31'])
                ->whereIn('pin2',[55,66,67])
                ->groupBy('att_date')
                ->groupBy('pin2')
                ->get();

                foreach($logs as $log)
                {                                        
                    $exiting = DB::table('final_attendances')->where('emp_id',$log->pin2)
                    ->whereDate('date',$log->att_date)            
                    ->first();

                    // Attedance Data Not Available
                    if($exiting==Null)
                    {
                        $empshifts = DB::table('employees')
                            ->select('employees.*','shifts.start_time','shifts.start_end')
                            ->leftJoin('shifts','shifts.id','=','employees.shift_id')
                            ->where('employees.code',$log->pin2)
                            ->first();

                        // Roster Available
                        if($empshifts->roster=='Yes')
                        {
                            //Roster
                            $rosterResult = DB::table('rosters')
                                ->select('employees.name as ename','shifts.start_time','shifts.start_end')
                                ->join('shifts','shifts.id','=','rosters.shift_id')
                                ->join('employees','employees.id','=','rosters.emp_id')
                                ->where('employees.code',$log->pin2)
                                ->where('rosters.roster_date',$log->att_date)
                                ->first();

                            if($rosterResult!=Null)
                            {
                                $shift_time = $rosterResult->start_time.'-'.$rosterResult->start_end;
                            }
                            else
                            {
                                $shift_time = '00:00:00-00:00:00';
                            }

                            //Compare
                            $inTimeFormat       = $log->att_date.' '.$log->InTime;
                            $outTimeFormat      = $log->att_date.' '.$log->OutTime;
                            $inShiftFormat      = $log->att_date.' '.$rosterResult->start_time.':00';
                            $outShiftFormat     = $log->att_date.' '.$rosterResult->start_end.':00';

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
                        elseif($empshifts->roster=='No')
                        {
                            //Roster
                            $rosterResult = DB::table('employees')
                            ->select('employees.*','shifts.start_time','shifts.start_end')
                            ->leftJoin('shifts','shifts.id','=','employees.shift_id')
                            ->where('employees.code',$log->pin2)
                            ->first();

                            if($rosterResult!=Null)
                            {
                                $shift_time = $rosterResult->start_time.'-'.$rosterResult->start_end;
                            }
                            else
                            {
                                $shift_time = Null;
                            }

                            //Compare
                            $inTimeFormat       = $log->att_date.' '.$log->InTime;
                            $outTimeFormat      = $log->att_date.' '.$log->OutTime;
                            $inShiftFormat      = $log->att_date.' '.$rosterResult->start_time.':00';
                            $outShiftFormat     = $log->att_date.' '.$rosterResult->start_end.':00';

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
                }


                // Attendance not found.
                $logs1 = DB::table('attendance_logs')
                ->select('pin2','att_date')
                ->whereBetween('att_date',['2022-11-01','2022-11-31'])
                ->whereIn('pin2',[55,66,67])
                ->get();

                foreach($logs1 as $log)
                {
                    $exiting = DB::table('final_attendances')->where('emp_id',$log->pin2)
                    ->whereDate('date',$att_date)            
                    ->first();

                    // Attedance Data Not Available
                    if($exiting==Null)
                    {
                        $empshifts = DB::table('employees')
                            ->select('employees.*','shifts.start_time','shifts.start_end')
                            ->leftJoin('shifts','shifts.id','=','employees.shift_id')
                            ->where('employees.code',$log->pin2)
                            ->first();

                        // Roster Available
                        if($empshifts->roster=='Yes')
                        {
                            //Roster
                            $rosterResult = DB::table('rosters')
                                ->select('employees.name as ename','shifts.start_time','shifts.start_end')
                                ->join('shifts','shifts.id','=','rosters.shift_id')
                                ->join('employees','employees.id','=','rosters.emp_id')
                                ->where('employees.code',$log->pin2)
                                ->where('rosters.roster_date',$log->att_date)
                                ->first();

                            $attendance_type = Null;
                            if($rosterResult!=Null)
                            {
                                $shift_time = $rosterResult->start_time.'-'.$rosterResult->start_end;
                            }
                            else
                            {
                                $shift_time = '00:00-00:00';
                            }                            

                            $addedAttenceID = DB::table('final_attendances')->insertGetId([
                                'emp_id'            => $log->pin2,
                                'in_time'           => '00:00:00',
                                'out_time'          => '00:00:00',
                                'shift_time'        => $shift_time,
                                'attendance_type'   => $attendance_type,
                                'remarks'           => Null,
                                'date'              => $att_date
                            ]);

                            $cdeRe = DB::table('final_attendances')->where('id',$addedAttenceID)
                                ->first();

                            if($cdeRe== true)
                            {
                                if($cdeRe->in_time=='00:00:00')
                                {
                                    $rosterResult = DB::table('rosters')
                                    ->select('employees.name as ename','shifts.start_time','shifts.start_end')
                                    ->join('shifts','shifts.id','=','rosters.shift_id')
                                    ->join('employees','employees.id','=','rosters.emp_id')
                                    ->where('employees.code',$cdeRe->emp_id)
                                    ->where('rosters.roster_date',$cdeRe->date)
                                    ->first();

                                    if($rosterResult->start_time == '00:00:00' && $rosterResult->start_end == '00:00:00')
                                    {
                                       $attendance_typee = 'Weekend';
                                    }
                                    else
                                    {
                                       $attendance_typee = 'Absent';
                                    }

                                    DB::table('final_attendances')->where('id',$cdeRe->id)
                                    ->update(
                                        [
                                            'attendance_type' => $attendance_typee
                                        ]
                                    );
                                }                                
                            }                            
                        }
                        elseif($empshifts->roster=='No')
                        {
                            $regularResult = DB::table('employees')
                            ->select('shifts.start_time','shifts.start_end')
                            ->join('shifts','shifts.id','=','employees.shift_id')
                            ->where('employees.code',$data->pin2)
                            ->first();

                            if($regularResult!=Null)
                            {
                                $shift_time = $regularResult->start_time.'-'.$regularResult->start_end;
                            }
                            else
                            {
                                $shift_time = '00:00:00-00:00:00';
                            }

                            $shift_time = $empshifts->start_time.'-'.$empshifts->start_end;

                            $NationalHoliday = DB::table('holidays')
                            ->whereDate('date',$att_date)
                            ->first();
                            
                            $remarks = Null;
                            if($NationalHoliday!=Null)
                            {
                                $attendance_type= 'National Holiday';
                                $remarks = $NationalHoliday->name;
                            }
                            else if(date('l',strtotime("$month/$i/$year"))=='Friday' || date('l',strtotime("$month/$i/$year"))=='Saturday')
                            {
                               $attendance_type= 'Weekend';
                            }
                            else
                            {
                               $attendance_type= 'Absent';
                            }

                            DB::table('final_attendances')->insert([
                                'emp_id'            => $log->pin2,
                                'in_time'           => '00:00:00',
                                'out_time'          => '00:00:00',
                                'shift_time'        => $shift_time,
                                'attendance_type'   => $attendance_type,
                                'remarks'           => $remarks,
                                'date'              => $att_date
                            ]);
                        }                        
                    }
                }
            }
        }

        return 0;

    }
}
