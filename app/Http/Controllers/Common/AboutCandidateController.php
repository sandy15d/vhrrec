<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\jf_contact_det;
use App\Models\jf_pf_esic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutCandidateController extends Controller
{
    public function candidate_detail()
    {
        return view('common.candidate_detail');
    }

    public function Candidate_PersonalData(Request $request)
    {
        $JCId   = $request->JCId;
        $query  = "SELECT JCId,Gender,Aadhaar,Nationality,Religion,OtherReligion,MaritalStatus,MarriageDate,SpouseName,Caste,OtherCaste,DrivingLicense,LValidity  FROM `jobcandidates` WHERE `JCId` = '$JCId'";
        $result = DB::select($query);
        if (!$result) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'data' => $result[0]]);
        }
    }

    public function Candidate_PersonalData_Save(Request $request)
    {
        $JCId   = $request->P_JCId;
        $Aadhaar = $request->Aadhaar;
        $Gender = $request->Gender;
        $Nationality = $request->Nationality;
        $Religion = $request->Religion;
        $OtherReligion = $request->OtherReligion;
        $MaritalStatus = $request->MaritalStatus;
        $MarriageDate = $request->MarriageDate;
        $SpouseName = $request->SpouseName;
        $Category = $request->Category;
        $OtherCategory = $request->OtherCategory;
        $DrivingLicense = $request->DrivingLicense;
        $LValidity = $request->LValidity;
        $query = DB::table('jobcandidates')
            ->where('JCId', $JCId)
            ->update(
                [
                    'Aadhaar' => $Aadhaar,
                    'Gender' => $Gender,
                    'Nationality' => $Nationality,
                    'Religion' => $Religion,
                    'OtherReligion' => $OtherReligion ?? null,
                    'MaritalStatus' => $MaritalStatus,
                    'MarriageDate' => $MarriageDate ?? null,
                    'SpouseName' => $SpouseName,
                    'Caste' => $Category,
                    'OtherCaste' => $OtherCategory ?? null,
                    'DrivingLicense' => $DrivingLicense,
                    'LValidity' => $LValidity,
                    'LastUpdated' => now()

                ]
            );
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
        }
    }

    public function Candidate_EmergencyContact(Request $request)
    {
        $JCId = $request->JCId;
        $query = "SELECT * FROM jf_contact_det WHERE JCId='$JCId'";
        $result = DB::select($query);
        if (!$result) {
            return response()->json(['status' => 400, 'msg' => 'No Record Found..!!']);
        } else {

            return response()->json(['status' => 200, 'data' => $result[0]]);
        }
    }

    public function Candidate_EmergencyContact_Save(Request $request)
    {
        $JCId = $request->Emr_JCId;
        $query = DB::table('jf_contact_det')->where('JCId', $JCId)->first();
        if ($query !== null) {
            $query1 = DB::table('jf_contact_det')->update(['cont_one_name' => $request->PrimaryName, 'cont_one_number' => $request->PrimaryPhone, 'cont_one_relation' => $request->PrimaryRelation, 'cont_two_name' => $request->SecondaryName, 'cont_two_number' => $request->SecondaryPhone, 'cont_two_relation' => $request->SecondaryRelation]);
        } else {
            $query1 = new jf_contact_det;
            $query1->JCId = $JCId;
            $query1->cont_one_name = $request->PrimaryName;
            $query1->cont_one_number = $request->PrimaryPhone;
            $query1->cont_one_relation = $request->PrimaryRelation;
            $query1->cont_two_name = $request->SecondaryName ?? null;
            $query1->cont_two_number = $request->SecondaryPhone ?? null;
            $query1->cont_two_relation = $request->SecondaryRelation ?? null;
            $query1->LastUpdated = now();
            $query1->save();
        }
        if (!$query1) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
        }
    }


    public function Candidate_BankInfo(Request $request)
    {
        $JCId = $request->JCId;
        $query = "SELECT * FROM jf_pf_esic WHERE JCId='$JCId'";
        $result = DB::select($query);
        if (!$result) {
            return response()->json(['status' => 400, 'msg' => 'No Record Found..!!']);
        } else {

            return response()->json(['status' => 200, 'data' => $result[0]]);
        }
    }

    public function Candidate_BankInfo_Save(Request $request)
    {
        $JCId = $request->Bank_JCId;
        $query = DB::table('jf_pf_esic')->where('JCId', $JCId)->first();
        if ($query !== null) {
            $query1 = DB::table('jf_pf_esic')->update([
                'UAN' => $request->UAN,
                'BankName' => $request->BankName,
                'BranchName' => $request->BranchName,
                'AccountNumber' => $request->AccountNumber,
                'IFSCCode' => $request->IFSCCode,
                'PFNumber' => $request->PFNumber,
                'ESICNumber' => $request->ESICNumber,
                'PAN' => $request->PAN,
                'LastUpdated' => now()
            ]);
        } else {
            $query1 = new jf_pf_esic;
            $query1->JCId = $JCId;
            $query1->UAN = $request->UAN;
            $query1->BankName = $request->BankName;
            $query1->BranchName = $request->BranchName;
            $query1->AccountNumber = $request->AccountNumber;
            $query1->IFSCCode = $request->IFSCCode;
            $query1->PFNumber = $request->PFNumber;
            $query1->ESICNumber = $request->ESICNumber;
            $query1->PAN = $request->PAN;
            $query1->LastUpdated = now();
            $query1->save();
        }
        if (!$query1) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
        }
    }

    public function Candidate_Family(Request $request)
    {
        $JCId = $request->JCId;
        $query = "SELECT * FROM jf_family_det WHERE JCId='$JCId'";
        $result = DB::select($query);
        if (!$result) {
            return response()->json(['status' => 400, 'msg' => 'No Record Found..!!']);
        } else {

            return response()->json(['status' => 200, 'data' => $result]);
        }
    }

    public function Candidate_Family_Save(Request $request)
    {
        $JCId = $request->Family_JCId;
        $Relation = $request->Relation;
        $RelationName = $request->RelationName;
        $RelationDOB = $request->RelationDOB;
        $RelationQualification = $request->RelationQualification;
        $RelationOccupation = $request->RelationOccupation;

        $query = DB::table('jf_family_det')->where('JCId', $JCId)->delete();

        $FamilyArray = array();
        for ($i = 0; $i < count($Relation); $i++) {
            $FamilyArray[$i] = array(
                'JCId' => $JCId,
                'relation' => $Relation[$i],
                'name' => $RelationName[$i],
                'dob' => $RelationDOB[$i],
                'qualification' => $RelationQualification[$i],
                'occupation' => $RelationOccupation[$i],
            );
        }

        $query1 = DB::table('jf_family_det')->insert($FamilyArray);
        if (!$query1) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {

            return response()->json(['status' => 200, 'msg' => 'Data has been changed successfully']);
        }
    }
}
