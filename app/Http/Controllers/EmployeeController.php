<?php

namespace App\Http\Controllers;
use App\Models\EmployeeModel;
use App\Models\ShiftManageModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use File;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pageIndex()
    {
        return view('frontend/employee/employeePage');
    }

    public function pageIndexResult()
    {
        $result = DB::table('employees')
        ->select('employees.*','departments.name as dname','designations.name as dename')
        ->leftJoin('departments','departments.id','=','employees.department_id')
        ->leftJoin('designations','designations.id','=','employees.designation_id')
        ->get();

        return response()->json(['data' => $result]);
    }


    public function create()
    {
        $shift          = ShiftManageModel::orderBy('id','DESC')->get();
        $department     = DepartmentModel::orderBy('id','DESC')->get();
        $designation    = DesignationModel::orderBy('id','DESC')->get();

        return view('frontend/employee/employeeCreatePage', compact('shift','department','designation'));
    }
    
    public function submit(Request $req)
    {
        $data=new EmployeeModel();
        $data->name                 = $req->get('employee_name');
        $data->email                = $req->get('email');
        $data->mobile               = $req->get('phone_number');
        $data->salary               = $req->get('salary');
        $data->code                 = $req->get('code_number');
        $data->joining_date         = date('Y-m-d',strtotime($req->get('join_date')));
        $data->birth_date           = date('Y-m-d',strtotime($req->get('birth_date')));
        if (request()->hasFile('image')){
            $uploadedImage = $req->file('image');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/users/');
            $uploadedImage->move($destinationPath, $imageName);
            $data->image = $imageName;
        }

        $data->gender               = $req->get('gender');
        $data->password             = Hash::make($req->get('password'));
        $data->department_id        = $req->get('department_id');
        $data->designation_id       = $req->get('designation_id');
        $data->shift_id             = $req->get('shift_id');
        $data->approval             = $req->get('approval_name');
        $data->created_user         = Auth::user()->id;
        $data->roster               = $req->get('roster');
        $data->created_at           = date('Y-m-d H:i:s');
        $data->save();

        if($req->get('approval_name')=='No')
        {
            $type = 'User';
            $typeRoster = 'No';
        }
        else{
            $type = 'Admin';
            $typeRoster = 'Yes';
        }

        $userdata = new UserModel();
        $userdata->name         = $req->get('employee_name');
        $userdata->email        = $req->get('email');
        $userdata->password     = Hash::make($req->get('password'));
        $userdata->type         = $type;
        $userdata->roster       = $typeRoster;
        $userdata->employee_id  = $data->id;        
        $userdata->save();
        
        return redirect()->route('employee')->with('success','Data has been successfully added');
    }

    public function update($id)
    {
        $shift          = ShiftManageModel::orderBy('id','DESC')->get();
        $department     = DepartmentModel::orderBy('id','DESC')->get();
        $designation    = DesignationModel::orderBy('id','DESC')->get();
        $result=EmployeeModel::where('id',$id)->first();
        return view('frontend/employee/employeeEdit', compact('result','shift','department','designation'));
        
    }
    public function submit_edit(Request $req)
    {
        $data=EmployeeModel::find($req->get('id'));
        $data->name                 = $req->get('employee_name');
        $data->email                = $req->get('email');
        $data->mobile               = $req->get('phone_number');
        $data->salary               = $req->get('salary');
        $data->code                 = $req->get('code_number');
        $data->joining_date         = date('Y-m-d',strtotime($req->get('join_date')));
        $data->birth_date           = date('Y-m-d',strtotime($req->get('birth_date')));
        if (request()->hasFile('image'))
        {
            $destination = 'uploads/users/'.$data->image;            
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $uploadedImage = $req->file('image');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/users/');
            $uploadedImage->move($destinationPath, $imageName);
            $data->image = $imageName;
        }
        if($req->get('password')!='')
        {
            $data->password         = Hash::make($req->get('password'));
        }
        $data->gender               = $req->get('gender');
        //$data->password             = Hash::make($req->get('password'));
        $data->department_id        = $req->get('department_id');
        $data->designation_id       = $req->get('designation_id');
        $data->shift_id             = $req->get('shift_id');
        $data->approval             = $req->get('approval_name');
        $data->created_user         = Auth::user()->id;
        $data->roster               = $req->get('roster');
        $data->updated_at           = date('Y-m-d H:i:s');
        $data->save();

        if($req->get('approval_name')=='No')
        {
            $type = 'User';
            $typeRoster = 'No';
        }
        else{
            $type = 'Admin';
            $typeRoster = 'Yes';
        }

        //dd($req->input('approval_name'));
        DB::table('users')->where('employee_id',$req->get('id'))->update([
            'name'              => $req->get('employee_name'),
            'email'             => $req->get('email'),
            'password'          => Hash::make($req->get('password')),
            'type'              => $type,
            'roster'            => $typeRoster,
            'employee_id'       => $req->get('id')
        ]);
        
        return redirect()->route('employee')->with('success','Data has been successfully updated');
    }
    public function delete($id)
    {
        EmployeeModel::find($id)->delete();    
        return redirect()->route('employee')->with('success','Data has been successfully delete');
    }

}
