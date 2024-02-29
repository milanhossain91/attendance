<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeAttendance extends Model
{
    protected $fillable = ['emp_id', 'att_date' ];

    public static function insert_val($params){
        DB::table('employee_attendances')->insert(
            ['emp_id' => $params['emp_id'],
            'dept_id' => $params['dept_id'],
            'att_date' => $params['att_date'],
            'in_out_time' => $params['in_out_time'],
            ]
        );
    }

    public function all_employee(){
        $all_emp_list = DB::table('employees as e')
            //->leftjoin('departments as d', 'e.dept_id','=','d.id')
            //->where('e.code', '=', $parameter)
            ->selectRaw('e.id, e.name, e.code')
            ->orderby('e.name', 'asc')
            ->get();
        return $all_emp_list;
    }

    public function update_val($params){
        DB::table('employee_attendances')
            ->where('id', 1)
            ->update(
                ['in_out_time' => $params['in_out_time']]
            );
    }

    public function insert_val_ajax($params){
        date_default_timezone_set('Asia/Dhaka');
        $save_emp_att = DB::table('employee_attendances')->insert(
            [   'emp_id'        => $params['empid'],
                'dept_id'       => $params['deptid'],
                'att_date'      => date('Y-m-d', strtotime($params['selectdate'])),
                'in_out_time'   => $params['inouttime'],
                'remarks'       => $params['remarks'],
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        );
        return $save_emp_att;
    }
}