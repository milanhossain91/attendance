<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveManageModel;
use App\Models\LeaveCategoryModel;
use App\Models\EmployeeModel;
use Auth;
use DB;
use Pusher\Pusher;
use Redirect;

class LeaveManageController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pageIndex()
    {
        return view('frontend/leaveManage/leaveManagePage');
    }

    public function pageIndexResult()
    {        
        if(Auth::user()->type=='User' || Auth::user()->type=='Head') 
        {
            $result = DB::table('leaves')
            ->select('leaves.*','leave_categorys.name as cname','users.name as uname','auser.name as aname')
            ->leftJoin('leave_categorys','leave_categorys.id','=','leaves.category_id')
            ->leftJoin('users','users.id','=','leaves.apply_userid')
            ->leftJoin('users as auser','auser.id','=','leaves.approved_userid')
            ->where('leaves.apply_userid', Auth::user()->id)
            ->orderBy('id','DESC')
            ->get();
        }
        else
        {
            $result = DB::table('leaves')
            ->select('leaves.*','leave_categorys.name as cname','users.name as uname','auser.name as aname')
            ->leftJoin('leave_categorys','leave_categorys.id','=','leaves.category_id')
            ->leftJoin('users','users.id','=','leaves.apply_userid')
            ->leftJoin('users as auser','auser.id','=','leaves.approved_userid')
            ->orderBy('id','DESC')
            ->get();
        }

        return response()->json(['data' => $result]);
    }

    public function create()
    {
        $leaveType  = LeaveCategoryModel::all();
        $info       = DB::table('employees')
        ->select('employees.name','employees.code','departments.name as deptname','designations.name as desiname')
        ->join('departments','departments.id','=','employees.department_id')
        ->join('designations','designations.id','=','employees.designation_id')
        ->where('employees.id', Auth::user()->employee_id)
        ->first();

        return view('frontend/leaveManage/leaveManageCreatePage', compact('leaveType','info'));
    }

    public function submit(Request $request)
    {
        $data = new LeaveManageModel();
        $data->category_id  = $request->get('category_id');
        $data->from_date    = date('Y-m-d',strtotime($request->get('from_date')));
        $data->to_date      = date('Y-m-d',strtotime($request->get('to_date')));
        $data->reason       = $request->get('reason');
        $data->No_of_days   = $request->get('No_of_days');
        $data->address_during_leave = $request->get('address_during_leave');
        $data->person_charge        = $request->get('person_charge');
        $data->reason       = $request->get('reason');
        $data->apply_userid = Auth::user()->id;
        $data->created_at   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('leave')->with('success', 'Data has been successfully added.');
    }

    public function edit($id)
    {
        $result       = DB::table('leaves')
        ->select('leaves.*','employees.name','employees.code','departments.name as deptname','designations.name as desiname')

        ->join('users','users.id','=','leaves.apply_userid')
        ->join('employees','employees.id','=','users.employee_id')
        ->join('departments','departments.id','=','employees.department_id')
        ->join('designations','designations.id','=','employees.designation_id')
        ->where('leaves.id', $id)
        ->first();

        $leaveType  = LeaveCategoryModel::all();
        return view('frontend/leaveManage/leaveManageEditPage', compact('result','leaveType'));
    }

    public function update(Request $request)
    {
        $data = LeaveManageModel::find($request->get('id'));
        $data->category_id  = $request->get('category_id');
        $data->from_date    = date('Y-m-d',strtotime($request->get('from_date')));
        $data->to_date      = date('Y-m-d',strtotime($request->get('to_date')));
        $data->reason       = $request->get('reason');
        $data->No_of_days   = $request->get('No_of_days');
        $data->address_during_leave = $request->get('address_during_leave');
        $data->person_charge        = $request->get('person_charge');
        $data->reason       = $request->get('reason');
        $data->apply_userid = Auth::user()->id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('leave')->with('success', 'Data has been successfully updated.');
    }

    public function delete($id)
    {
        LeaveManageModel::where('id',$id)->delete();
        return redirect()->route('leave')->with('success', 'Data has been successfully deleted.');
    }

    public function waitingLeave()
    {           
        return view('frontend/leaveManage/pendingLeavePage');
    }

    public function waitingLeaveResult()
    {   
        $userDeptInfo = EmployeeModel::find(Auth::user()->employee_id)->first();

        $result = DB::table('leaves')
        ->select('leaves.*','leave_categorys.name as categoryName','users.employee_id','users.name','employees.department_id','employees.name as empName')

        ->leftJoin('leave_categorys','leave_categorys.id','=','leaves.category_id')
        ->leftJoin('users','users.id','=','leaves.apply_userid')
        ->leftJoin('employees','employees.id','=','users.employee_id')
        ->where('employees.department_id',$userDeptInfo->department_id)
        ->get();
        
        return response()->json(['data' => $result]);
    }

    public function approved($type,$id)
    {
        $data = LeaveManageModel::find($id);
        $data->approved         = $type;
        $data->approved_userid  = Auth::user()->id;
        $id = $data->approved_userid;
        $data->approved_date    = date('Y-m-d H:i:s');
        $data->save();

        // $options = array(
        //   'cluster' => 'ap2',
        //   'useTLS' => true
        // );

        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     $options
        // );

        // $data = ['from' => $id];
        // $pusher->trigger('my-channel', 'my-event', $id);

        return Redirect::back()->with('success', 'Data has been successfully updated.');
    }
}
