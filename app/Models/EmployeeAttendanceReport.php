<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceReport extends Model
{
    public function post_today_attendance($params,$parameter)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m-d'); $selectday = date('d');}else{$selectdt = date('Y-m-d',strtotime($params));$selectday = date('d',strtotime($params));}

        $today_emp_attendance = DB::table('attendance_logs as ea')
            ->leftjoin('profiles as e', 'e.pin2','=','ea.pin2')
            //->leftjoin('departments as d', 'd.id','=','ea.dept_id')
            ->leftjoin('rosters as r', 'ea.att_date','=','r.roster_date')
            ->leftjoin(DB::raw("(SELECT s.*, r.shift_id, r.roster_date, r.emp_id FROM shifts s left join rosters r on s.id=r.shift_id where r.roster_date = '".$selectdt."') as rs"), 'rs.emp_id', '=', 'ea.pin2')
            ->where('e.status', '=', '1')
            ->where('e.type', '=', $parameter)
            //->where('d.status', '=', '1')
            ->where('ea.att_date', '=', $selectdt)
            ->selectRaw('e.id, ea.pin2, e.fullname, ea.att_date, min(ea.in_out_time) as intime, max(ea.in_out_time) as outtime, ea.remarks, rs.shift_id, rs.shift_name, rs.start_time as shift_start_time')
            ->groupBy('ea.pin2','ea.att_date')
            ->orderby('intime', 'asc')
            ->orderby('e.fullname', 'asc')
            ->get();

        /*$today_emp_attendance = DB::table('employee_attendances as ea')
            ->leftjoin('employees as e', 'e.id','=','ea.emp_id')
            ->leftjoin('departments as d', 'd.id','=','ea.dept_id')
            ->leftjoin('rosters as r', 'ea.att_date','=','r.roster_date')
            ->leftjoin(DB::raw("(SELECT s.*, r.shift_id, r.roster_date, r.emp_id FROM shifts s left join rosters r on s.id=r.shift_id where r.roster_date = '".$selectdt."') as rs"), 'rs.emp_id', '=', 'ea.emp_id')
            ->where('e.status', '=', '1')
            ->where('d.status', '=', '1')
            ->where('ea.att_date', '=', $selectdt)
            ->selectRaw('e.id, e.fullname, e.emp_designation, e.dept_id, d.dept_name, ea.att_date, min(ea.in_out_time) as intime, max(ea.in_out_time) as outtime, ea.remarks, rs.shift_id, rs.shift_name, rs.start_time as shift_start_time')
            ->groupBy('ea.emp_id','ea.att_date')
            ->orderby('intime', 'asc')
            ->orderby('e.fullname', 'asc')
            ->get();*/
        //dd($today_emp_attendance);
        return $today_emp_attendance;
    }

    public function emp_dept_list($parameter )
    {
        date_default_timezone_set('Asia/Dhaka');

        $today_emp_attendance = DB::table('profiles as e')
            ->where('e.status', '=', '1')
            ->where('e.type', '=', $parameter)
            ->selectRaw('e.*')
            ->orderby('e.fullname', 'asc')
            ->get();
        //dd($today_emp_attendance);
        return $today_emp_attendance;
    }

    public function get_today_attendance($parameter)
    {
        date_default_timezone_set('Asia/Dhaka');
        $selectdt  = date('Y-m-d');
        $selectday = date('d');


        $today_emp_attendance = DB::table('attendance_logs as ea')
            ->leftjoin('profiles as e', 'e.pin2','=','ea.pin2')
            //->leftjoin('departments as d', 'd.id','=','ea.dept_id')
            ->leftjoin('rosters as r', 'ea.att_date','=','r.roster_date')
            ->leftjoin(DB::raw("(SELECT s.*, r.shift_id, r.roster_date, r.emp_id FROM shifts s left join rosters r on s.id=r.shift_id where r.roster_date = '".$selectdt."') as rs"), 'rs.emp_id', '=', 'ea.pin2')
            ->where('e.status', '=', '1')
            ->where('e.type', '=', $parameter)
            //->where('d.status', '=', '1')
            ->where('ea.att_date', '=', $selectdt)
            ->selectRaw('e.id, ea.pin2, e.fullname, ea.att_date, min(ea.in_out_time) as intime, max(ea.in_out_time) as outtime, ea.remarks, rs.shift_id, rs.shift_name, rs.start_time as shift_start_time')
            ->groupBy('ea.pin2','ea.att_date')
            ->orderby('intime', 'asc')
            ->orderby('e.fullname', 'asc')
            ->get();
        //dd($today_emp_attendance);
        return $today_emp_attendance;
    }

    public function get_late_time($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$month  = date('m'); $year  = date('Y');}else{$explode = explode("-", $params);$month = $explode[1]; $year = $explode[0];}

        $today_late_time  = DB::select("select late_time, max_late_time from late_time_setups where month=$month and year=$year limit 1");
        if(!empty($today_late_time)){
            $orglatetime = $today_late_time[0]->late_time;
            $maxlatetime = $today_late_time[0]->max_late_time;
        }else{
            $orglatetime = '00:00:00';
            $maxlatetime = '00:00:00';
        }

        return $orglatetime.'-'.$maxlatetime;
    }

    public function emp_monthly_late_report($params,$emp_id)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');}else{$selectdt = $params['year'].'-'.$params['month'];}
        $start_dt       = $selectdt.'-01';
        $end_dt         = $selectdt.'-31';

        $getorglatetime = $this->get_late_time($selectdt);
        $explod         = explode('-',$getorglatetime);
        $orglatetime    = $explod[0];
        $maxlatetime    = $explod[1];

        $today_emp_attendance = DB::table('attendance_logs as ea')
            ->leftjoin('profiles as e', 'e.id','=','ea.emp_id')
            ->leftjoin('departments as d', 'd.id','=','ea.dept_id')
            ->leftjoin('rosters as r', 'ea.att_date','=','r.roster_date')
            ->leftjoin(DB::raw("(SELECT s.*, r.shift_id, r.roster_date, r.emp_id FROM shifts s left join rosters r on s.id=r.shift_id where r.roster_date between '".$start_dt."' and '".$end_dt."' and r.emp_id = $emp_id) as rs"), 'rs.roster_date', '=', 'ea.att_date')
            ->where('e.status', '=', '1')
            ->where('d.status', '=', '1')
            ->where('ea.emp_id', '=', $emp_id)
            ->whereBetween('ea.att_date',[$start_dt,$end_dt])
            ->selectRaw('e.id, e.fullname, e.emp_designation, e.dept_id, d.dept_name, ea.att_date, min(ea.in_out_time) as intime, max(ea.in_out_time) as outtime, ea.remarks, rs.shift_id, rs.shift_name, rs.start_time as shift_start_time')
            ->groupBy('ea.emp_id','ea.att_date')
            ->orderby('e.fullname', 'asc')
            ->orderby('ea.att_date', 'asc')
            ->get();

        $late_count = 0;
        foreach($today_emp_attendance as $i=>$att)
        {
            if(empty($att->shift_start_time)){return 'Setup Office Time !!!';}


            $intime     = '00:00:00';
            $latetime   = '00:00:00';
            $othertime  = '00:00:00';
            $mlatetime  = '00:00:00';
            if($att->shift_start_time != '00:00:00')
            {
                $intime     = $att->intime;
                $secs       = strtotime($orglatetime)-strtotime("00:00:00");
                $maxsecs    = strtotime($maxlatetime)-strtotime("00:00:00");
                $latetime   = date("H:i:s",strtotime($att->shift_start_time));
                $othertime  = date("H:i:s",strtotime($att->shift_start_time)+$secs);
                $mlatetime  = date("H:i:s",strtotime($att->shift_start_time)+$maxsecs);
            }

            if($intime > $latetime)$late_count = $late_count+1;
            if(($othertime > $latetime) && ($intime > $othertime))$late_count = $late_count+1;
            if(($mlatetime > $othertime) && ($intime > $mlatetime))$late_count = $late_count+1;
        }

        return $late_count;
    }

    public function emp_ttl_leave_last_punch($params,$emp_id)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');}else{$selectdt = $params['year'].'-'.$params['month'];}
        $start_dt       = $selectdt.'-01';
        $end_dt         = $selectdt.'-31';

        $emp_last_attendance = DB::table('attendance_logs as ea')
            ->leftjoin('profiles as e', 'e.id','=','ea.emp_id')
            ->where('e.status', '=', '1')
            ->where('ea.emp_id', '=', $emp_id)
            ->whereBetween('ea.att_date',[$start_dt,$end_dt])
            ->selectRaw('max(ea.att_date) as last_punch_date')
            ->get();
        $last_punch_date = $emp_last_attendance[0]->last_punch_date;

        $till_ttl_off = 0;
        $monthly_holidays_lists = DB::table('office_monthly_holidays as omh')
            ->where('omh.status', '=', '1')
            ->where('omh.month', '=', $params['month'])
            ->where('omh.year', '=', $params['year'])
            ->whereBetween('omh.holiday_dt',[$start_dt,$last_punch_date])
            ->select('omh.holiday_dt')
            ->count();
        $till_ttl_off = $till_ttl_off+$monthly_holidays_lists;

        $monthly_leave_lists = DB::select("SELECT e.id, COALESCE( ttl_leave, '0') as ttl_leave
                                FROM profiles e
                                left join ( select count(el.emp_leaves_id) as ttl_leave, el.emp_id from `emp_leaves` el
                                where el.leave_date between '$start_dt' and '$last_punch_date'
                                group by el.emp_id ) as leaves
                                on e.id=leaves.emp_id where e.id='$emp_id' order by e.id asc");
        $till_ttl_off = $till_ttl_off+$monthly_leave_lists[0]->ttl_leave;

        $has_off_day = DB::table('shifts')
            ->where([
                'roster_month'  => $params['month'],
                'roster_year'   => $params['year'],
                'start_time'    => '00:00:00',
                'end_time'      => '00:00:00'
            ])
            ->limit(1)
            ->get();
        (count($has_off_day)>0) ? $off_day_shift = $has_off_day[0]->id : $off_day_shift = '';

        $monthly_off_day_lists = DB::select("SELECT count(*) as ttl_off_day
                              FROM `rosters` as r
                              where r.shift_id = '$off_day_shift' and r.emp_id=$emp_id and r.roster_date between '$start_dt' and '$last_punch_date' group by emp_id ORDER BY r.`emp_id` ASC ");
        if($monthly_off_day_lists)$till_ttl_off = $till_ttl_off+$monthly_off_day_lists[0]->ttl_off_day;

        return $till_ttl_off;
    }

    public function count_emp_monthly_present($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');}else{$selectdt = $params['year'].'-'.$params['month'];}

        $count_present  = DB::select("SELECT e.id, count(DISTINCT ea.att_date) as ttl_present
                          FROM profiles e
                          left join attendance_logs ea on e.id=ea.emp_id
                          where att_date like '$selectdt%'
                          group by ea.emp_id ORDER BY ea.emp_id, `ea`.`att_date` ASC ");
        //dd($count_present);
        return $count_present;
    }

    public function emp_monthly_salary_info($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');}else{$selectdt = $params['year'].'-'.$params['month'];}

        $emp_monthly_salary_info = DB::table('profiles as e')
            ->leftjoin('departments as d', 'd.id','=','e.dept_id')
            ->leftjoin('employee_salaries as es', 'e.id','=','es.emp_id')
            ->where('e.status', '=', '1')
            ->selectRaw('e.id, e.fullname, e.emp_designation, e.dept_id, d.dept_name, es.salary_amount, es.deduction_rate')
            ->orderby('e.fullname', 'asc')
            ->get();
        //dd($count_present);
        return $emp_monthly_salary_info;
    }

    public function monthly_holidays($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$month  = date('n');$year  = date('Y');}else{$month  = (int)$params['month'];$year  = $params['year'];}

        $monthly_holidays_lists = DB::table('office_monthly_holidays as omh')
            ->where('omh.status', '=', '1')
            ->where('omh.month', '=', $month)
            ->where('omh.year', '=', $year)
            ->select('omh.holiday_dt')
            ->count();
        //$monthly_holidays_list = explode(',',$monthly_holidays_lists);
        //dd($monthly_holidays_list);
        return $monthly_holidays_lists;
    }

    public function employees_monthly_leave($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');}else{$selectdt = $params['year'].'-'.$params['month'];}

        $monthly_leave_lists = DB::select("SELECT e.id, COALESCE( ttl_leave, '0') as ttl_leave
                                FROM profiles e
                                left join ( select count(el.emp_leaves_id) as ttl_leave, el.emp_id from `emp_leaves` el
                                where el.leave_date like '$selectdt%'
                                group by el.emp_id ) as leaves
                                on e.id=leaves.emp_id order by e.id asc");

        return $monthly_leave_lists;
    }

    public function employees_monthly_off_day($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');}else{$selectdt = $params['year'].'-'.$params['month'];}

        $has_off_day = DB::table('shifts')
                        ->where([
                            'roster_month'  => $params['month'],
                            'roster_year'   => $params['year'],
                            'start_time'    => '00:00:00',
                            'end_time'      => '00:00:00'
                        ])
                        ->limit(1)
                        ->get();
        (count($has_off_day)>0) ? $off_day_shift = $has_off_day[0]->id : $off_day_shift = '';

        $monthly_off_day_lists = DB::select("SELECT r.emp_id, count(*) as ttl_off_day
                              FROM `rosters` as r
                              where r.shift_id = '$off_day_shift' group by emp_id ORDER BY r.`emp_id` ASC ");

        return $monthly_off_day_lists;
    }

    public function employees_dt_range_off_day($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m');$start_dt = $selectdt.'-01';$end_dt = $selectdt.'-'.date('d');}else{$selectdt = $params['year'].'-'.$params['month'];$start_dt = $selectdt.'-01';$end_dt = $selectdt.'-'.$params['day'];}

        $has_off_day = DB::table('shifts')
                        ->where([
                            'roster_month'  => $params['month'],
                            'roster_year'   => $params['year'],
                            'start_time'    => '00:00:00',
                            'end_time'      => '00:00:00'
                        ])
                        ->limit(1)
                        ->get();
        (count($has_off_day)>0) ? $off_day_shift = $has_off_day[0]->id : $off_day_shift = '';

        $monthly_off_day_lists = DB::select("SELECT r.emp_id, count(*) as ttl_off_day
                              FROM `rosters` as r
                              where r.shift_id = '$off_day_shift' and r.roster_date between '$start_dt' and '$end_dt' group by emp_id ORDER BY r.`emp_id` ASC ");

        return $monthly_off_day_lists;
    }

    public function post_emp_attendance_date_range($params)
    {
        //DB::enableQueryLog();
        date_default_timezone_set('Asia/Dhaka');
        $emp_id     = $params['emp_id'];
        $parameter  = $params['parameter'];
        $start_dt   = date('Y-m-d',strtotime($params['start_dt']));
        $end_dt     = date('Y-m-d',strtotime($params['end_dt']));


        $emp_attendance_daterange = DB::table('final_attendances')
        ->where('emp_id', $emp_id)
        ->whereBetween('date', [$start_dt,$end_dt])
        ->orderBy('date','ASC')
        ->get();

        // $emp_attendance_daterange = DB::table('attendance_logs as ea')
        //     ->leftjoin('employees as e', 'e.code','=','ea.pin2')
        //     ->leftjoin('shifts as s', 'e.shift_id','=','s.id')
        //     ->where('e.code', '=', $emp_id)
        //     ->where('ea.pin2', '=', $emp_id)
        //     ->whereBetween('ea.att_date',[$start_dt,$end_dt])
        //     ->selectRaw('e.id, e.name, ea.pin2, ea.att_date, min(ea.in_out_time) as intime, max(ea.in_out_time) as outtime, ea.remarks, s.id, s.start_time, s.start_end, s.title as shift_title')
        //     ->groupBy('ea.pin2','ea.att_date')
        //     ->orderby('e.name', 'asc')
        //     ->orderby('ea.att_date', 'asc')
        //     ->get();
        //dd(DB::getQueryLog());
        return $emp_attendance_daterange;
    }

    public function emp_monthly_salary_report($params)
    {
        date_default_timezone_set('Asia/Dhaka');
        if($params == ''){$selectdt  = date('Y-m-d');}else{$selectdt = date('Y-m-d',strtotime($params));}

        $today_emp_attendance  = DB::table('attendance_logs as ea')
            ->leftjoin('profiles as e', 'e.id','=','ea.emp_id')
            ->leftjoin('departments as d', 'd.id','=','ea.dept_id')
            ->where('e.status', '=', '1')
            ->where('d.status', '=', '1')
            ->where('ea.att_date', '=', $selectdt)
            ->selectRaw('e.id, e.fullname, e.emp_designation, e.dept_id, d.dept_name, min(ea.in_out_time) as intime, max(ea.in_out_time) as outtime, ea.remarks')
            ->groupBy('ea.emp_id')
            ->orderby('e.fullname', 'asc')
            ->get();
        //dd($results);
        return $today_emp_attendance;
    }

    /*public function date_range_transaction($params)
    {
        //DB::enableQueryLog();
        date_default_timezone_set('Asia/Dhaka');
        $start_dt   = date('Y-m-d',strtotime($params['start_dt']));
        $end_dt     = date('Y-m-d',strtotime($params['end_dt']));

        $emp_attendance_daterange = DB::table('package_profile as pp')
            ->leftjoin(DB::raw("(SELECT sum(package_histories.paid) as paid, package_histories.payment_date FROM package_histories where package_histories.payment_date between '".$start_dt."' and '".$end_dt."' group by payment_date order by payment_date) as ph "), 'ph.package_profile_id', '=', 'pp.id')
            //->where('e.status', '=', '1')
            ->whereBetween('pp.created_at',[$start_dt,$end_dt])
            ->selectRaw('pp.id, pp.amount, ph.package_profile_id, ph.pai')
            //->groupBy('ea.pin2','ea.att_date')
            //->orderby('e.fullname', 'asc')
            ->get();
        //dd(DB::getQueryLog());
        return $emp_attendance_daterange;
    }*/
}
