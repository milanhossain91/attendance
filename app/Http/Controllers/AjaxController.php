<?php
namespace App\Http\Controllers;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAttendanceReport;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libraries\Zk_class;
class AjaxController extends Controller
{
    public function postEmpAttendance(Request $request)
    {
        $input          = $request->all();//print_r($input['inouttime']);
        //$emp_att_model  = new EmployeeAttendance();
        $emp_att_model  = new EmployeeAttendance();
        $emp_att_model->insert_val_ajax($input);
        if($emp_att_model)
        {
            $response = array(
                'status' => 'success',
                'msg' => 'Save succesfully',
            );
        }ELSE{
            $response = array(
                'status' => 'failur',
                'msg' => 'Save fail',
            );
        }
        return response()->json($response);
    }

    public function postDailyAttendance(Request $request)
    {
        $input          = $request->all();//print_r($input['inouttime']);
        //$emp_att_model  = new EmployeeAttendance();
        $emp_att_report_model       = new EmployeeAttendanceReport();
        $emp_att_report_datewise    = $emp_att_report_model->datewise_attendance($input);
        if($emp_att_report_datewise)
        {
            $response = array(
                'status' => 'success',
                'msg' => 'Save succesfully',
            );
        }ELSE{
            $response = array(
                'status' => 'failur',
                'msg' => 'Save fail',
            );
        }
        return response()->json($response);
    }

    public function rSchedule(Request $request)
    {
        //dd($request->all());
        $requests   = $request->all();
        $value      = explode(":",$requests['value']);
        $day        = date('j',$value[1]);
        $month      = date('n',$value[1]);
        $year       = date('Y',$value[1]);
        $user_id    = Auth::user()->id;

        Roster::updateOrCreate(
            ['day' => $day, 'month' => $month, 'year' => $year, 'emp_id' => $value[2]],
            ['roster_date' => date('Y-m-d',$value[1]), 'shift_id' => $value[0], 'created_by' => $user_id]
        );

        $response = 'success';
        //dd($response);
        return response()->json($response);
    }

    public function postAttDevice(Request $request)
    {
        $input          = $request->all();

        //return view('admin.zk.zk');
        //$ip         = '58.84.34.22';
        $ip         = '58.84.34.26';
        $zkClass    = new Zk_class();
        $emp_data   = $zkClass->connect($ip);
        $messages   = '';

        $all_emp            = new EmployeeAttendance();
        $all_employee       = $all_emp->all_employee();

        if ($emp_data['logs'] != 0)
        {
            foreach ($emp_data['logs']['Row'] as $log)
            {
                // get user card number
                $uid = '';
                foreach ($emp_data['users']['Row'] as $u_info) {
                    if ($u_info['PIN2'] == $log['PIN'])
                        $uid = $log['PIN'];
                }

                $dept_id = 1;
                if(array_search($uid, array_column($all_employee->toArray(), 'id'))) {
                    $key        = array_search($uid, array_column($all_employee->toArray(), 'id'));
                    $dept_id    = $all_employee[$key]->dept_id;
                }

                if(isset($uid)) {
                    $data[] = [
                        'emp_id'        => $uid,
                        'dept_id'       => $dept_id,
                        'att_date'      => date('Y-m-d', strtotime(strip_tags(trim($log['DateTime'])))),
                        'in_out_time'   => date('H:i:s', strtotime(strip_tags(trim($log['DateTime'])))),
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ];
                }// data insert end
            } // emp data red end
            DB::table('employee_attendances')->truncate();
            //DB::table('employee_attendances')->insert($data);
            foreach (array_chunk($data,700) as $t) {
                DB::table('employee_attendances')->insert($t);
            }
            $messages .= " Branch was connected and data has been successfully imported.<br/>";
        }else{
            $messages .= " Branch was not connected. Please check the ip.<br/>";
        }// emp data get check end


        if($emp_data)
        {
            $response = array(
                'status'    => 'success',
                'msg'       => $messages,
            );
        }ELSE{
            $response = array(
                'status'    => 'failur',
                'msg'       => 'Save fail',
            );
        }
        return response()->json($response);
    }


    //// Roster Reset
    public function rosterReset(Request $request)
    {
        $requests   = $request->all();
        $value      = explode(":",$requests['value']);
        
        Roster::where('emp_id',$value[1])
        ->where('roster_date',date('Y-m-d',$value[2]))
        ->delete();

        toastr()->warning('If click any roster time, auto-saved.');

        //$response = 'success';
        return back();
    }
}
