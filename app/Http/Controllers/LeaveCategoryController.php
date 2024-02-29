<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveCategoryModel;
use Auth;

class LeaveCategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pageIndex()
    {
        $result = LeaveCategoryModel::orderBy('id','DESC')->get();

        return view('frontend/leaveCategory/leaveCategoryPage', compact('result'));
    }

    public function pageIndexResult()
    {
        $result = LeaveCategoryModel::orderBy('id','DESC')->get();
        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/leaveCategory/leaveCategoryCreatePage');
    }

    public function submit(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|unique:leave_categorys|max:255'
        // ],
        // [
        //     'name.required'=> 'This leave type already exists.', // custom message
        // ]);

        $data = new LeaveCategoryModel();
        $data->name         = $request->get('category_name');
        $data->days         = $request->get('days');
        $data->userid       = Auth::user()->id;
        $data->created_at   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('leave-type')->with('success', 'Data has been successfully added.');
    }

    public function edit($id)
    {
        $result = LeaveCategoryModel::where('id',$id)->first();
        return view('frontend/leaveCategory/leaveCategoryEditPage', compact('result'));
    }

    public function update(Request $request)
    {
        $data = LeaveCategoryModel::find($request->get('id'));
        $data->name         = $request->get('category_name');
        $data->days         = $request->get('days');
        $data->userid       = Auth::user()->id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();

        return redirect()->route('leave-type')->with('success', 'Data has been successfully updated.');
    }

    public function delete($id)
    {
        LeaveCategoryModel::where('id',$id)->delete();
        return redirect()->route('leave-type')->with('success', 'Data has been successfully deleted.');
    }
}
