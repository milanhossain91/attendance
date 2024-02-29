<?php

namespace App\Http\Controllers;
use App\Models\DepartmentModel;
use Illuminate\Http\Request;
use Auth;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pageIndex()
    {
        $result = DepartmentModel::orderBy('id','DESC')->get();
        return view('frontend/department/departmentPage', compact('result'));
    }

    public function pageIndexResult()
    {
        $result = DepartmentModel::orderBy('id','DESC')->get();
        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/department/departmentCreatePage');
    }
    
    public function submit(Request $req)
    {
        $data=new DepartmentModel();
        $data->name         = $req->get('department_name');
        $data->userid       = Auth::user()->id;
        $data->created_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('department')->with('success','Data has been successfully added');
    }

    public function update($id)
    {
        $result=DepartmentModel::where('id',$id)->first();
        return view('frontend/department/departmentEdit', compact('result'));
        
    }
    public function submit_edit(Request $req)
    {
        $data=DepartmentModel::find($req->get('id'));
        $data->name         = $req->get('department_name');
        $data->userid       = Auth::user()->id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('department')->with('success','Data has been successfully updated');
    }
    public function delete($id)
    {
        DepartmentModel::find($id)->delete();    
        return redirect()->route('department')->with('success','Data has been successfully delete');
    }

}
