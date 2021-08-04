<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\master_headquarter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DataTables;

class HeadquarterController extends Controller
{
    public function headquarter()
    {
        return view('admin.headquarter');
    }
    public function getAllHeadquarter()
    {
        $headquarter = DB::table('master_headquater')
            ->join('master_company', 'master_headquater.CompanyId', '=', 'master_company.CompanyId')
            ->join('master_state', 'master_headquater.StateId', '=', 'master_state.StateId')
            ->select(['master_headquater.*', 'master_company.CompanyCode', 'master_state.StateName']);

        return Datatables::of($headquarter)
            ->addIndexColumn()
            ->make(true);
    }

    public function syncHeadquarter()
    {

        $query =  master_headquarter::truncate();
        $response = Http::get('https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Headquarter')->json();
        $data = array();
        foreach ($response['Headquarter_list'] as $key => $value) {

            $temp = array();
            $temp['HqId'] = $value['HqId'];
            $temp['HqName'] = $value['HqName'];
            $temp['StateId'] = $value['StateId'];
            $temp['CompanyId'] = $value['CompanyId'];
            array_push($data, $temp);
        }
        $query = master_headquarter::insert($data);


        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Headquarter data has been Synchronized.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
