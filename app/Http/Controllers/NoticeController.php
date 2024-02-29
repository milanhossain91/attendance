<?php

namespace App\Http\Controllers;
use App\Models\NoticeModel;
use Illuminate\Http\Request;
use Auth;
class NoticeController extends Controller
{
    public function pageIndex()
    {
        $result=NoticeModel::orderBy('id','DESC')->get();
        return view('frontend/notice/noticePage', compact('result'));
    }

    public function create()
    {
        return view('frontend/notice/noticeCreatePage');
    }
    public function submit(Request $req)
    {
        $data=new NoticeModel();
        $data->title         = $req->get('notice_title');
        $data->details       = $req->get('details');
        $data->status        = $req->get('status_name');
        $data->expire_date   = date('Y-m-d', strtotime($req->get('expire_date')));
        $data->created_at    = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('notice')->with('success','Data has been successfully added');
    }
    public function update($id)
    {
        $result=NoticeModel::where('id',$id)->first();
        return view('frontend/notice/noticeEdit', compact('result'));
        
    }
    public function submit_edit(Request $req)
    {
        $data=NoticeModel::find($req->get('id'));
        $data->title         = $req->get('notice_title');
        $data->details       = $req->get('details');
        $data->status        = $req->get('status_name');
        $data->expire_date   = date('Y-m-d', strtotime($req->get('expire_date')));
        $data->updated_at    = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('notice')->with('success','Data has been successfully updated');
    }
    public function delete($id)
    {
        NoticeModel::find($id)->delete();    
        return redirect()->route('notice')->with('success','Data has been successfully delete');
    }


    // Employee
    public function noticeAll()
    {
        $result=NoticeModel::where('status',0)->orderBy('id','DESC')->get();
        return view('frontend/notice/noticeAll', compact('result'));
    }

}

