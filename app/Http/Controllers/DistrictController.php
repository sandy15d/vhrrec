<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\master_district;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;

class DistrictController extends Controller
{
    // ?=====================Load State Page===================
    function district()
    {
        $state_list = DB::table("states")->orderBy('StateName', 'asc')->pluck("StateName", "StateId");
        return view('admin.district', compact('state_list'));
    }


    // ?===============Insert District records in Database===================
    public function addDistrict(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'DistrictName' => 'required',
            'State' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $district = new master_district;
            $district->DistrictName = $request->DistrictName;
            $district->StateId = $request->State;
            $district->IsDeleted = '0';
            $district->Status = $request->Status;
            $query = $district->save();

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
            LogActivity::addToLog('New District '.$request->DistrictName.' has been created');
                return response()->json(['status' => 200, 'msg' => 'New District has been successfully created.']);
            }
        }
    }

    // ?====================Get All Company Data From Datatabse=====================

    public function getAllDistrict()
    {
        $district = DB::table('districts')->join('states', 'states.StateId', '=', 'districts.StateId')
            ->select(['districts.*', 'states.StateName']);

        return Datatables::of($district)
            ->addIndexColumn()
            ->addColumn('actions', function ($district) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $district->DistrictId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $district->DistrictId . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get State Details for Edit ========================//

    public function getDistrictDetails(Request $request)
    {
        $DistrictId = $request->DistrictId;
        $DistrictDetails = master_district::find($DistrictId);
        return response()->json(['DistrictDetails' => $DistrictDetails]);
    }

    // ?=====================Update State Details===================
    public function editDistrict(Request $request)
    {
        $DistrictId = $request->districtId;
        $validator = Validator::make($request->all(), [
            'editDistrict' => 'required',
            'editState' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $district = master_district::find($DistrictId);
            $district->DistrictName = $request->editDistrict;
            $district->StateId = $request->editState;
            $district->Status = $request->editStatus;
            $query = $district->save();
            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'District data has been changed successfully.']);
            }
        }
    }

    // !=======================Delete Company ===============================//

    public function deleteDistrict(Request $request)
    {
        $DistrictId = $request->DistrictId;
        $query = master_district::find($DistrictId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'District data has been Deleted.']);
        }
    }
}
