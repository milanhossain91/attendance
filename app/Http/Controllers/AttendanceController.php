<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAttendanceReport;
use App\Mail\DailyAttendanceMail;
use App\Mail\SalaryReportMail;
use App\Models\DepartmentModel;
use App\Models\EmployeeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AttendanceController extends Controller
{

    private $user_type;
    private $user_id;

    public function __construct()
    {
        $this->middleware('auth');
        //$this->user_type= Auth::user()->type;
        //$this->user_id  = Auth::user()->employee_id;
    }

    public function employeeWiseAttendance($request)
    {
        $data['dept_id']                    = '';
        $data['emp_id']                     = 1;
        $data['start_dt']                   = date('d-m-Y');
        $data['end_dt']                     = date('d-m-Y');
        $parameter                          = $request;
        $emp_att                            = new EmployeeAttendance();
        $emp_att_report                     = new EmployeeAttendanceReport();
        $data['parameter']                  = $parameter;
        $data['all_department']             = DepartmentModel::where('status',0)->get();
        $data['all_employee']               = $emp_att->all_employee();
        if(Auth::user()->type=='Head'){ $hdept_id = EmployeeModel::where('code',Auth::user()->employee_id)->get('department_id');
                                        $data['all_employee'] = EmployeeModel::where('department_id',$hdept_id[0]->department_id)->get();}
        $data['emp_attendance_date_range']  = $emp_att_report->post_emp_attendance_date_range($data);
        $data['emp_attendance_report_model']= $emp_att_report; // send model instance for call it's function from view
        return view('frontend/attendance/attendancePage', $data);
    }

    public function postEmployeeWiseAttendance(Request $request)
    {
        $data['dept_id']                    = $request->dept_id;
        $data['emp_id']                     = $request->emp_id;
        $data['start_dt']                   = $request->start;
        $data['end_dt']                     = $request->end;
        $data['parameter']                  = $request->parameter;
        $emp_att                            = new EmployeeAttendance();
        $emp_att_report                     = new EmployeeAttendanceReport();
        $data['all_department']             = DepartmentModel::where('status',0)->get();
        $data['all_employee']               = $emp_att->all_employee();
        if(Auth::user()->type=='Head'){ $hdept_id = EmployeeModel::where('code',Auth::user()->employee_id)->get('department_id');
                                        $data['all_employee'] = EmployeeModel::where('department_id',$hdept_id[0]->department_id)->get();}
        
        $data['emp_attendance_date_range']  = $emp_att_report->post_emp_attendance_date_range($data);//dd($data['emp_attendance_date_range']);
        $data['emp_attendance_report_model']= $emp_att_report; // send model instance for call it's function from view
        return view('frontend/attendance/attendancePage', $data);
    }

    public function fetchEmployee(Request $request)
    {
        $dept_id            = $request->id;
        $data['employees']  = EmployeeModel::where('department_id',$dept_id)->get();

        return response()->json($data);
    }
}
