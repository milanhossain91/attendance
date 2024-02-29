<?php

namespace App\Http\Controllers;
use App\Models\EmployeeModel;
use App\Models\ShiftManageModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\UserModel;
use App\Models\Roster;

use Illuminate\Http\Request;

use Auth;
use DB;

class RosterController extends Controller
{
    public function index()
    {
        $emp_list   = DB::table('employees')
            ->select('employees.*','departments.name as dname','designations.name as dename')
            ->leftJoin('departments','departments.id','=','employees.department_id')
            ->leftJoin('designations','designations.id','=','employees.designation_id')
            ->where('employees.roster','Yes')
            ->get();

        $shift_list = DB::table('shifts as s')
            ->where('s.status', '=', '1')
            //->where('s.roster_month', '=', date('m'))
            //->where('s.roster_year', '=', date('Y'))
            ->orderby('s.id', 'asc')
            ->get();

        $r_calendar         = $this->r_calendar();//dd($data['r_calendar']);
        $data['r_calendar'] = $this->r_calendar();//dd($data['r_calendar']);

        // loop start here
        foreach($emp_list as $key => $value)
        {
            $rcal = array();
            foreach($r_calendar as $j=>$calendarval)
            {
                $roster = DB::table('rosters as r')
                    ->where('r.status', '=', '1')
                    ->where('r.emp_id', '=', $value->id)
                    ->where('r.roster_date', '=', date('Y-m-d',$calendarval))
                    ->limit(1)
                    ->get();
                $rcal[$j]['rcal'] = $calendarval;
                $rcal[$j]['rshift'] = $shift_list;
                //dd($rcal[$j]['rshift']);
                if(count($roster)>0){$rcal[$j]['rrshift'] = $roster[0]->shift_id;}else{$rcal[$j]['rrshift'] = '';}
            }
            $emp_list[$key]->calendarval    = $rcal;
        }

        $data['employees_time'] = $emp_list;
        return view('frontend/roster/roster_setup_time', $data);
    }

    public function store(Request $request)
    {
        //
    }
    public function show(Roster $roster)
    {
        //
    }
    public function edit(Roster $roster)
    {
        //
    }
    public function update(Request $request, Roster $roster)
    {
        //
    }
    public function destroy(Roster $roster)
    {
        //
    }

    private function r_calendar()
    {
        $month  = date('m');
        $year   = date('Y');

        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);
        $end_time   = strtotime("+1 month", $start_time);

        for($i=$start_time; $i<$end_time; $i+=86400)
        {
            //$list[] = date('Y-m-d-D', $i);
            $list[] =  $i;
        }
        return $list;
    }


    // Employee
    public function rosterSchedule()
    {
        $emp_list   = DB::table('employees')
            ->select('employees.*','departments.name as dname','designations.name as dename')
            ->leftJoin('departments','departments.id','=','employees.department_id')
            ->leftJoin('designations','designations.id','=','employees.designation_id')
            ->where('employees.roster','Yes')
            ->get();

        $shift_list = DB::table('shifts as s')
            ->where('s.status', '=', '1')
            //->where('s.roster_month', '=', date('m'))
            //->where('s.roster_year', '=', date('Y'))
            ->orderby('s.id', 'asc')
            ->get();

        $r_calendar         = $this->r_calendar();//dd($data['r_calendar']);
        $data['r_calendar'] = $this->r_calendar();//dd($data['r_calendar']);

        // loop start here
        foreach($emp_list as $key => $value)
        {
            $rcal = array();
            foreach($r_calendar as $j=>$calendarval)
            {
                $roster = DB::table('rosters as r')
                    ->where('r.status', '=', '1')
                    ->where('r.emp_id', '=', $value->id)
                    ->where('r.roster_date', '=', date('Y-m-d',$calendarval))
                    ->limit(1)
                    ->get();
                $rcal[$j]['rcal'] = $calendarval;
                $rcal[$j]['rshift'] = $shift_list;
                //dd($rcal[$j]['rshift']);
                if(count($roster)>0){$rcal[$j]['rrshift'] = $roster[0]->shift_id;}else{$rcal[$j]['rrshift'] = '';}
            }
            $emp_list[$key]->calendarval    = $rcal;
        }

        $data['employees_time'] = $emp_list;
        return view('frontend/roster/rosterResetShow', $data);
    }
}
