<?php

namespace App\Http\Controllers;
use App\Models\HolidayModel;
use Illuminate\Http\Request;
use Auth;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pageIndex()
    {
        $result = HolidayModel::orderBy('id','DESC')->get();
        return view('frontend/holidays/holidayPage', compact('result'));
    }

    public function pageIndexResult()
    {
        $result = HolidayModel::orderBy('id','DESC')->get();
        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/holidays/holidayCreatePage');
    }

    public function submit(Request $req)
    {
        $data= new HolidayModel();
        $data->name         = $req->get('holiday_name');
        $data->date         = date('Y-m-d',strtotime($req->get('holiday_date')));
        $data->userid       = Auth::user()->id;
        $data->created_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('holidays')->with('success','Data has been successfully added');
    }
    public function update($id)
    {
        $result=HolidayModel::where('id',$id)->first();
        return view('frontend/holidays/holidayEdit', compact('result'));        
    }

    public function submit_edit(Request $req)
    {
        $data=HolidayModel::find($req->get('id'));
        $data->name         = $req->get('holiday_name');
        $data->date         = date('Y-m-d',strtotime($req->get('holiday_date')));
        $data->userid       = Auth::user()->id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('holidays')->with('success','Data has been successfully updated');
    }

    public function delete($id)
    {
        HolidayModel::find($id)->delete();    
        return redirect()->route('holidays')->with('success','Data has been successfully delete');
    }
}
