<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShiftManageModel;
use Auth;

class ShiftManageController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pageIndex()
    {
        return view('frontend/shiftManage/shiftManagePage');
    }

    public function pageIndexResult()
    {
        $result = ShiftManageModel::orderBy('id','DESC')->get();
        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/shiftManage/shiftManageCreatePage');
    }

    public function submit(Request $request)
    {
        $x = explode("-",$request->get('month'));
        $data = new ShiftManageModel();
        $data->shift_name   = $request->get('shift_name');
        $data->short_name   = $request->get('short_name');
        $data->start_time   = $request->get('start_time');
        $data->start_end    = $request->get('end_time');
        $data->roster_month = $x[1];
        $data->roster_year  = $x[0];
        $data->status       = 1;
        $data->created_by   = Auth::user()->id;
        $data->created_at   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('shift')->with('success', 'Data has been successfully added.');
    }

    public function edit($id)
    {
        $result     = ShiftManageModel::where('id',$id)->first();
        return view('frontend/shiftManage/shiftManageEditPage', compact('result'));
    }

    public function update(Request $request)
    {
        $x = explode("-",$request->get('month'));
        $data = ShiftManageModel::find($request->get('id'));
        $data->shift_name   = $request->get('shift_name');
        $data->short_name   = $request->get('short_name');
        $data->start_time   = $request->get('start_time');
        $data->start_end    = $request->get('end_time');
        $data->roster_month = $x[1];
        $data->roster_year  = $x[0];
        $data->status       = 1;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('shift')->with('success', 'Data has been successfully updated.');
    }

    public function delete($id)
    {
        ShiftManageModel::where('id',$id)->delete();
        return redirect()->route('shift')->with('success', 'Data has been successfully deleted.');
    }
}
