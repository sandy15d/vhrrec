<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\master_country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;


class CountryController extends Controller
{

    // ?=====================Load Country Page===================
    function country()
    {

        return view('admin.country');
    }


    // ?===============Insert Country records in Database===================
    public function addCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CountryName' => 'required',
            'CountryCode' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $country = new master_country();
            $country->CountryName = $request->CountryName;
            $country->CountryCode = $request->CountryCode;
            $country->Status = $request->Status;
            $country->CreatedBy = Auth::user()->id;
            $query = $country->save();

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'New Country has been successfully created.']);
            }
        }
    }

    // ?====================Get All Country Data From Datatabse=====================

    public function getAllCountryData()
    {
        $company = master_country::all();
        return Datatables::of($company)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $row['CountryId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $row['CountryId'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get Country Details for Edit ========================//

    public function getCountryDetails(Request $request)
    {
        $CountryId = $request->CountryId;
        $CountryDetails = master_country::find($CountryId);
        return response()->json(['CountryDetails' => $CountryDetails]);
    }

    // ?=====================Update Company Details===================
    public function editCountry(Request $request)
    {
        $CountryId = $request->cid;
        $validator = Validator::make($request->all(), [
            'editCountryName' => 'required',
            'editCountryCode' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            // DB::enableQueryLog();
            $country = master_country::find($CountryId);
            $country->CountryName = $request->editCountryName;
            $country->CountryCode = $request->editCountryCode;
            $country->Status = $request->editStatus;
            $country->UpdatedBy = Auth::user()->id;
            $country->LastUpdated = now();
            $query = $country->save();
            // $sql = DB::getQueryLog();
            //  dd($sql);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'Country data has been changed successfully.']);
            }
        }
    }

    // !=======================Delete Company ===============================//

    public function deleteCountry(Request $request)
    {
        $CountryId = $request->CountryId;
        $query = master_country::find($CountryId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Company data has been Deleted.']);
        }
    }

    // *====================== Synchronize Company Data From ESS =============================//

    public function syncCountry()
    {

        $query =  master_country::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Country')->json();
        $data = array();
        foreach ($response['Country_list'] as $key => $value) {
            $temp = array();
            $temp['CountryName'] = $value['Country'];
            $temp['CountryCode'] = '';
            $temp['Status'] = $value['Status'];
            $temp['CreatedBy'] = Auth::user()->id;
            array_push($data, $temp);
        }
        $query = master_country::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Country data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
