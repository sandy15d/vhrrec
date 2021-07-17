<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\master_state;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class StateController extends Controller
{
    // ?=====================Load State Page===================
    function state()
    {

        return view('admin.state');
    }


    // ?===============Insert Company records in Database===================
    public function addState(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'StateName' => 'required',
            'StateCode' => 'required',
            'Country' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $State = new master_state;
            $State->StateName = $request->StateName;
            $State->StateCode = $request->StateCode;
            $State->Country = $request->Country;
            $State->Status = $request->Status;
            $State->CreatedBy = Auth::user()->id;
            $query = $State->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New State has been successfully created.']);
            }
        }
    }

    // ?====================Get All Company Data From Datatabse=====================

    public function getAllStateData()
    {
        $state = DB::table('master_state')->join('master_country', 'master_state.Country', '=', 'master_country.CountryId')
            ->select(['master_state.StateId', 'master_state.StateName', 'master_state.StateCode', 'master_country.CountryName', 'master_state.Status']);

        return Datatables::of($state)
            ->addIndexColumn()
            ->addColumn('actions', function ($state) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $state->StateId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $state->StateId. '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get State Details for Edit ========================//

    public function getStateDetails(Request $request)
    {
        $StateId = $request->StateId;
        $StateDetails = master_state::find($StateId);
        return response()->json(['StateDetails' => $StateDetails]);
    }

    // ?=====================Update State Details===================
    public function editState(Request $request)
    {
        $StateId = $request->stid;
        $validator = Validator::make($request->all(), [
            'editStateName' => 'required',
            'editStateCode' => 'required',
            'editCountry' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            // DB::enableQueryLog();
            $State = master_state::find($StateId);
            $State->StateName = $request->editStateName;
            $State->StateCode = $request->editStateCode;
            $State->Country = $request->editCountry;
            $State->Status = $request->editStatus;
            $State->UpdatedBy = Auth::user()->id;
            $State->LastUpdated = now();
            $query = $State->save();
            // $sql = DB::getQueryLog();
            //  dd($sql);

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'State data has been changed successfully.']);
            }
        }
    }

    // !=======================Delete Company ===============================//

    public function deleteState(Request $request)
    {
        $StateId = $request->StateId;
        $query = master_state::find($StateId)->delete();
        if (!$query) {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'State data has been Deleted.']);
        }
    }

    // *====================== Synchronize Company Data From ESS =============================//

    public function syncState()
    {

        $query =  master_state::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=State')->json();
        $data = array();
        foreach ($response['State_list'] as $key => $value) {
            $temp = array();
            $temp['StateName'] = $value['State'];
            $temp['StateCode'] = $value['StateCode'];
            $temp['Country'] = $value['CountryId'];
            $temp['Status'] = $value['Status'];
            $temp['CreatedBy'] = Auth::user()->id;
            array_push($data, $temp);
        }
        $query = master_state::insert($data);


        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'State data has been Synchronized.']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong..!!']);
        }
    }
}
