<?php

namespace App\Http\Controllers;
use App\Models\DesignationModel;
use Illuminate\Http\Request;
use Auth;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pageIndex()
    {
        $result = DesignationModel::orderBy('id','DESC')->get();
        return view('frontend/designation/designationPage', compact('result'));
    }

    public function pageIndexResult()
    {
        $result = DesignationModel::orderBy('id','DESC')->get();
        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/designation/designationCreatePage');
    }

    public function submit(Request $req)
    {
        $data=new DesignationModel();
        $data->name         = $req->get('designation_name');
        $data->userid       = Auth::user()->id;
        $data->created_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('designation')->with('success','Data has been successfully added');
    }

    public function update($id)
    {
        $result=DesignationModel::where('id',$id)->first();
        return view('frontend/designation/designationEdit', compact('result'));
        
    }

    public function submit_edit(Request $req)
    {
        $data=DesignationModel::find($req->get('id'));
        $data->name         = $req->get('designation_name');
        $data->userid       = Auth::user()->id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('designation')->with('success','Data has been successfully updated');
    }

    public function delete($id)
    {
        DesignationModel::find($id)->delete();    
        return redirect()->route('designation')->with('success','Data has been successfully delete');
    }
}
