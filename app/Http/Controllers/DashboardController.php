<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LeaveCategoryModel;
use App\Models\EmployeeModel;
use App\Models\DepartmentModel;
use App\Models\LeaveManageModel;
use App\Models\UserModel;
use App\Models\NoticeModel;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pageIndex()
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
            ->get()->take(3);
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

        $employeeTotal      = EmployeeModel::count();
        $departmentTotal    = DepartmentModel::count();
        $notice             = NoticeModel::where('status',0)->get();
        $presentToday       = 0;
        $absentToday        = LeaveManageModel::where('from_date',date('Y-m-d'))->where('to_date',date('Y-m-d'))->where('approved','Approved')->count();

        if(Auth::user()->type=='Admin')
        {
            return view('frontend/middlePageAdmin', compact('result','employeeTotal','departmentTotal','presentToday','absentToday','notice'));
        }
        elseif(Auth::user()->type=='Head')
        {
            return view('frontend/middlePageHead', compact('result','employeeTotal','departmentTotal','presentToday','absentToday','notice'));
        }
        elseif(Auth::user()->type=='User')
        {
            return view('frontend/middlePageUser', compact('result','employeeTotal','departmentTotal','presentToday','absentToday','notice'));
        }        
    }

    public function themeChange(Request $request)
    {
        $val='No';
        if($request->get('theme')==1)
        {
            $val='Yes';
        }

        $user = UserModel::find(Auth::user()->id);
        $user->dark_theme = $val;
        $user->save();
    }
}
