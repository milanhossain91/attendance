<?php

namespace App\Http\Controllers;
use App\Models\AdjustmentModel;
use App\Models\EmployeeModel;
use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;

class AdjustmentController extends Controller
{
    public function pageIndex()
    {
        return view('frontend/adjustment/adjustmentPage');
    }

    public function pageIndexResult()
    {
        if(Auth::user()->type=='User' || Auth::user()->type=='Head')
        {
            $result = DB::table('adjustments')
                ->select('adjustments.*','users.name as uname')
                ->leftJoin('users','users.id','=','adjustments.userid')
                ->where('adjustments.userid', Auth::user()->id)
                ->orderBy('adjustments.id','DESC')
                ->get();
        }
        else
        {
            $result = DB::table('adjustments')
                ->select('adjustments.*','users.name as uname')
                ->leftJoin('users','users.id','=','adjustments.userid')
                // ->where('adjustments.userid', Auth::user()->id)
                ->orderBy('adjustments.id','DESC')
                ->get();
        }        

        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/adjustment/adjustmentCreatePage');
    }

    public function submit(Request $req)
    {
        DB::table('adjustments')->insert([
            'adjustment_date' => date('Y-m-d',strtotime($req->get('adjustment_date'))),
            'status' => $req->get('status_type'),
            'time' => $req->get('adjustment_time'),
            'userid' => Auth::user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
        ]);
        
        return redirect()->route('adjustment')->with('success','Data has been successfully added');
    }

    public function update($id)
    {
        $result=AdjustmentModel::where('id',$id)->first();
        return view('frontend/adjustment/adjustmentEdit', compact('result'));
        
    }

    public function submit_edit(Request $req)
    {
        DB::table('adjustments')->where('id',$req->get('id'))->update([
            'adjustment_date' => date('Y-m-d',strtotime($req->get('adjustmet_date'))),
            'status' => $req->get('status_type'),
            'time' => $req->get('adjustment_time'),
            'userid' => Auth::user()->id,
            'updated_at' =>date('Y-m-d H:i:s'),
        ]);
        
        return redirect()->route('adjustment')->with('success','Data has been successfully updated');
    }

    public function delete($id)
    {
        AdjustmentModel::find($id)->delete();    
        return redirect()->route('adjustment')->with('success','Data has been successfully delete');
    }



    ////// Approval ///////

    public function adjustmentApproval()
    {
        return view('frontend/adjustment/adjustmentApprovalPage');
    }

    public function adjustmentApprovalResult()
    {        
        $userDeptInfo = EmployeeModel::find(Auth::user()->employee_id)->first();

        $result = DB::table('adjustments')
        ->select('adjustments.*','users.employee_id','users.name','employees.department_id','employees.name as empName')

        ->leftJoin('users','users.id','=','adjustments.userid')
        ->leftJoin('employees','employees.id','=','users.employee_id')
        ->where('employees.department_id',$userDeptInfo->department_id)
        ->get();
        
        return response()->json(['data' => $result]);
    }

    public function approvedOrReject($type,$id)
    {
        DB::table('adjustments')->where('id',$id)->update([
            'approval'          => $type,
            'approved_userid'   => Auth::user()->id,
            'approved_date'     => date('Y-m-d')
        ]);

        return Redirect::back()->with('success','Data has been successfully done.');
    }
}
