<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\master_company;
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
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
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
                return response()->json(['code' => 0, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New Company has been successfully created.']);
            }
        }
    }

    // ?====================Get All Company Data From Datatabse=====================

    public function getAllCompanyData()
    {
        $company = master_company::all();
        return Datatables::of($company)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $row['CompanyId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $row['CompanyId'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get Company Details for Edit ========================//

    public function getCompanyDetails(Request $request)
    {
        $CompanyId = $request->CompanyId;
        $CompanyDetails = master_company::find($CompanyId);
        return response()->json(['CompanyDetails'=>$CompanyDetails]);
    }

    public function editCompany(Request $request)
    {
        # code...
    }
}
