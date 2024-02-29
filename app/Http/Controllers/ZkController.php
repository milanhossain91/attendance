<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataMigrationController;
//use App\Models\EmployeeAttendance;
use App\Models\Zk;
use Illuminate\Http\Request;
use App\Libraries\Zk_class;
use DB;
use Grimthorr\LaravelToast\Toast;

class ZkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $emp_data;
    function __construct(){
        $ip             = '58.84.34.26:1211';
        $zkClass        = new Zk_class($ip);
        $this->emp_data = $zkClass->connect();
    }
    
    public static function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zk  $zk
     * @return \Illuminate\Http\Response
     */
    public function show(Zk $zk)
    {
        //flash('Welcome!');
        //flash('Click Below Button to Start Upload Data');
        //flash('Please Wait......! If Success then Show Succeed Message');
        return view('frontend/zk/zk');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zk  $zk
     * @return \Illuminate\Http\Response
     */
    public function edit(Zk $zk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zk  $zk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zk $zk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zk  $zk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zk $zk)
    {
        //
    }

    // Auto
    public function postAttDeviceAuto()
    {
        $tadObj = $this->emp_data;
        $logs   = $tadObj->get_att_log()->to_array();

        if($logs):
            $datas['logs'] 	= $logs;
            $datas['users'] = $tadObj->get_all_user_info()->to_array();
            $datas['tad'] 	= $tadObj;
        else:
            $datas['logs']  = 0;
            $datas['users'] = $tadObj->get_all_user_info()->to_array();
            $datas['tad'] 	= $tadObj;
        endif;

        $messages   = '';
        if ($datas['logs'] != 0)
        {
            $max_att_dt = DB::select("SELECT max(att_date) as max_att_dt FROM attendance_logs_store");
            $get_max_dt = $max_att_dt[0]->max_att_dt;

            foreach ($datas['logs']['Row'] as $log)
            {
                $data[] = [
                    'pin2'          => $log['PIN'],
                    'att_date'      => date('Y-m-d', strtotime(strip_tags(trim($log['DateTime'])))),
                    'in_out_time'   => date('H:i:s', strtotime(strip_tags(trim($log['DateTime'])))),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ];
            } // emp data red end
            DB::table('attendance_logs')->truncate();
            //DB::table('employee_attendances')->insert($data);
            foreach (array_chunk($data,700) as $t) {
                DB::table('attendance_logs')->insert($t);
            }
            
            //for insert data logs store table
            $records = array_filter($data, function ($row) use($get_max_dt) {
                return $row['att_date'] >= $get_max_dt;
            });
            
            DB::table('attendance_logs_store')
            ->where('att_date',$max_att_dt[0]->max_att_dt)
            ->delete();
            
            foreach (array_chunk($records,700) as $t) {
                DB::table('attendance_logs_store')->insert($t);
            }

            $migrationCon = new DataMigrationController();
            $migrationCon->attedanceDataMigration();

            $messages .= " Branch was connected and data has been successfully imported.<br/>";
        }else{
            $messages .= " Branch was not connected. Please check the ip.<br/>";
        }// emp data get check end


        IF($datas)
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

    //Manual
    public function postAttDevice(Request $request)
    {
        $input      = $request->all();

        //return view('admin.zk.zk');
        //$ip         = '58.84.33.218';
        //$zkClass    = new Zk_class($ip);
        $tadObj = $this->emp_data;
        $logs   = $tadObj->get_att_log()->to_array();

        if($logs):
            $datas['logs']  = $logs;
            $datas['users'] = $tadObj->get_all_user_info()->to_array();
            $datas['tad']   = $tadObj;
        else:
            $datas['logs']  = 0;
            $datas['users'] = $tadObj->get_all_user_info()->to_array();
            $datas['tad']   = $tadObj;
        endif;

        $messages   = '';
        if ($datas['logs'] != 0)
        {
            $max_att_dt = DB::select("SELECT max(att_date) as max_att_dt FROM attendance_logs_store");
            $get_max_dt = $max_att_dt[0]->max_att_dt;

            foreach ($datas['logs']['Row'] as $log)
            {
                $data[] = [
                    'pin2'          => $log['PIN'],
                    'att_date'      => date('Y-m-d', strtotime(strip_tags(trim($log['DateTime'])))),
                    'in_out_time'   => date('H:i:s', strtotime(strip_tags(trim($log['DateTime'])))),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ];
            } // emp data red end
            DB::table('attendance_logs')->truncate();
            //DB::table('employee_attendances')->insert($data);
            foreach (array_chunk($data,700) as $t) {
                DB::table('attendance_logs')->insert($t);
            }
            
            //for insert data logs store table
            $records = array_filter($data, function ($row) use($get_max_dt) {
                return $row['att_date'] >= $get_max_dt;
            });
            
            DB::table('attendance_logs_store')
            ->where('att_date',$max_att_dt[0]->max_att_dt)
            ->delete();
            
            foreach (array_chunk($records,700) as $t) {
                DB::table('attendance_logs_store')->insert($t);
            }

            $migrationCon = new DataMigrationController();
            $migrationCon->attedanceDataMigration();

            $messages .= " Branch was connected and data has been successfully imported.<br/>";
        }else{
            $messages .= " Branch was not connected. Please check the ip.<br/>";
        }// emp data get check end


        IF($datas)
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
}
