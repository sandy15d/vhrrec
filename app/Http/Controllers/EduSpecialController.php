<?php

namespace App\Http\Controllers;

use App\Models\master_specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class EduSpecialController extends Controller
{
    function eduspecialization()
    {
        $edu_list = DB::table("master_education")->where('Status', 'A')->orderBy('EducationCode', 'asc')->pluck("EducationCode", "EducationId");
        return view('admin.eduspecialization', compact('edu_list'));
    }
    // ?===============Insert Education records in Database===================
    public function addEduSpe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EducationName' => 'required',
            'EducationCode' => 'required',
            'EducationType' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $Education = new master_specialization;
            $Education->EducationName = $request->EducationName;
            $Education->EducationCode = $request->EducationCode;
            $Education->EducationType = $request->EducationType;
            $Education->Status = $request->Status;
            $query = $Education->save();

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'New Education has been successfully created.']);
            }
        }
    }

    // ?====================Get All Education Data From Datatabse=====================

    public function getAllEduSpe()
    {
        $Education = master_specialization::all();

        return Datatables::of($Education)
            ->addIndexColumn()
            ->addColumn('actions', function ($Education) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $Education['EducationId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
           <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $Education['EducationId'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get Education Details for Edit ========================//

    public function getEduSpeDetails(Request $request)
    {
        $EducationId = $request->EducationId;
        $EducationDetails = master_specialization::find($EducationId);
        return response()->json(['EducationDetails' => $EducationDetails]);
    }

    // ?=====================Update Education Details===================
    public function editEduSpe(Request $request)
    {
        $EducationId = $request->EId;
        $validator = Validator::make($request->all(), [
            'editEducationName' => 'required',
            'editEducationCode' => 'required',
            'editEducationType' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $education = master_specialization::find($EducationId);
            $education->EducationName = $request->editEducationName;
            $education->EducationCode = $request->editEducationCode;
            $education->EducationType = $request->editEducationType;
            $education->Status = $request->editStatus;
            $query = $education->save();
            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'Education data has been changed successfully.']);
            }
        }
    }

    public function deleteEduSpe(Request $request)
    {
        $EducationId = $request->EducationId;
        $query = master_specialization::find($EducationId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Education data has been Deleted.']);
        }
    }
}
