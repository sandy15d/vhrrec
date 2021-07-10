<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\master_company;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class CompanyController extends Controller
{
    function company()
    {
        return view('admin.company');
    }

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
                return response()->json(['code'=>1,'msg'=>'New Company has been successfully created.']);
            }
        }
    }
}
