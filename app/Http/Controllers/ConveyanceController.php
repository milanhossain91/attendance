<?php

namespace App\Http\Controllers;
use App\Models\ConveyanceModel;
use Illuminate\Http\Request;
use Auth;
use DB;

class ConveyanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pageIndex()
    {
        $result = ConveyanceModel::orderBy('id','DESC')->get();
        return view('frontend/conveyance/conveyancePage', compact('result'));
    }

    public function pageIndexResult()
    {
        $result = DB::table('conveyances')
        ->select('conveyances.*','users.name')
        ->join('users','users.id','=','conveyances.visited_by')
        ->get();

        return response()->json(['data' => $result]);
    }

    public function create()
    {
        return view('frontend/conveyance/conveyanceCreatePage');
    }

    public function submit(Request $request)
    {
        dd($request->all());

        $data= new ConveyanceModel();
        $data->name_of_the_projects = $request->get('name_of_the_projects');
        $data->assigned_person      = $request->get('assigned_person_id');
        $data->helping_hand_person  = $request->get('helping_hand_person');
        $data->visited_by           = $request->get('assigned_person_id');
        $data->created_at           = date('Y-m-d H:i:s');
        $data->save();

        $count = count($request->get('date'));

        for ($i=0; $i < $count; $i++) { 
            DB::table('conveyance_details')->insert([
                'conveyances_id'    => $data->id,
                'date'              => $request->get('con_date')[$i],
                'from'              => $request->get('con_from')[$i],
                'to'                => $request->get('con_to')[$i],
                'by'                => $request->get('con_by')[$i],
                'person'            => $request->get('con_person')[$i],
                'cost'              => $request->get('con_cost')[$i]
            ]);
        }
        
        return redirect()->route('conveyances')->with('success','Data has been successfully added');
    }
    public function update($id)
    {
        $result=ConveyanceModel::where('id',$id)->first();
        return view('frontend/conveyance/conveyanceEdit', compact('result'));        
    }

    public function submit_edit(Request $req)
    {
        $data=ConveyanceModel::find($req->get('id'));
        $data->name         = $req->get('holiday_name');
        $data->date         = date('Y-m-d',strtotime($req->get('holiday_date')));
        $data->userid       = Auth::user()->id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();
        
        return redirect()->route('conveyances')->with('success','Data has been successfully updated');
    }

    public function delete($id)
    {
        ConveyanceModel::find($id)->delete();    
        return redirect()->route('conveyances')->with('success','Data has been successfully delete');
    }
}
