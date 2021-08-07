<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin\master_company;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;


class CompanyController extends Controller
{

    // ?=====================Load Company Page===================
    function company()
    {

        return view('admin.company');
    }


    // ?===============Insert Company records in Database===================
    public function addCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CompanyName' => 'required',
            'CompanyCode' => 'required',
            'Address' => 'required',
            'Phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $company = new master_company;
            $company->CompanyName = $request->CompanyName;
            $company->CompanyCode = $request->CompanyCode;
            $company->Address = $request->Address;
            $company->Phone = $request->Phone;
            $company->Status = $request->Status;
            $company->CreatedBy = Auth::user()->id;
            $query = $company->save();

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'New Company has been successfully created.']);
            }
        }
    }

    // ?====================Get All Company Data From Datatabse=====================

    public function getAllCompanyData()
    {
        $company = master_company::all();
        return datatables()::of($company)
            ->addIndexColumn()
            ->addColumn('actions', function ($company) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $company['CompanyId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $company['CompanyId'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get Company Details for Edit ========================//

    public function getCompanyDetails(Request $request)
    {
        $CompanyId = $request->CompanyId;
        $CompanyDetails = master_company::find($CompanyId);
        return response()->json(['CompanyDetails' => $CompanyDetails]);
    }

    // ?=====================Update Company Details===================
    public function editCompany(Request $request)
    {
        $CompanyId = $request->cid;
        $validator = Validator::make($request->all(), [
            'editCompanyName' => 'required',
            'editCompanyCode' => 'required',
            'editAddress' => 'required',
            'editPhone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            // DB::enableQueryLog();
            $company = master_company::find($CompanyId);
            $company->CompanyName = $request->editCompanyName;
            $company->CompanyCode = $request->editCompanyCode;
            $company->Address = $request->editAddress;
            $company->Phone = $request->editPhone;
            $company->Status = $request->editStatus;
            $company->UpdatedBy = Auth::user()->id;
            $company->LastUpdated = now();
            $query = $company->save();
            // $sql = DB::getQueryLog();
            //  dd($sql);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'Company data has been changed successfully.']);
            }
        }
    }

    // !=======================Delete Company ===============================//

    public function deleteCompany(Request $request)
    {
        $CompanyId = $request->CompanyId;
        $query = master_company::find($CompanyId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Company data has been Deleted.']);
        }
    }

    // *====================== Synchronize Company Data From ESS =============================//

    public function syncCompany()
    {

        $query =  master_company::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Company')->json();
        $data = array();
        foreach ($response['company_list'] as $key => $value) {
            $temp = array();
            $temp['CompanyName'] = $value['CompanyName'];
            $temp['CompanyCode'] = '';
            $temp['Address'] = $value['address'];
            $temp['Phone'] = $value['Phone'];
            $temp['Status'] = $value['Status'];
            $temp['CreatedBy'] = Auth::user()->id;
            array_push($data, $temp);
        }
        $query = master_company::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Company data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
