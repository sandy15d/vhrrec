<?php

namespace App\Http\Controllers;

use App\Models\CandidateJoining;
use App\Models\OfferLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessToEss extends Controller
{
  

    public function processDataToEss(Request $request)
    {

        /*  $JAId = $request->JAId;
        $EmpCode = CandidateJoining::where('JAId', $JAId)->value('EmpCode');
        $CompanyId = OfferLetter::where('JAId', $JAId)->value('Company');
        $ctc_query = DB::table('candidate_ctc')->where('JAId', $JAId)->first();

       */


        try {
            \DB::connection('mysql2')->getPDO();
            dump('Database connected: ' . \DB::connection('mysql2')->getDatabaseName());
        } catch (\Exception $e) {
            dump('Database connected: ' . $e);
        }


        /*  $SendCTC = $SendCTC->table('EmployeeCTC')->insert([
            'EmpCode' => $EmpCode,
            'CompanyId' => $CompanyId,
            'basic' => $ctc_query->basic,
            'hra' => $ctc_query->hra,
            'bonus' => $ctc_query->bonus,
            'special_alw' => $ctc_query->special_alw,
            'grsM_salary' => $ctc_query->grsM_salary,
            'emplyPF' => $ctc_query->emplyPF,
            'emplyESIC' => $ctc_query->emplyESIC,
            'netMonth' => $ctc_query->netMonth,
            'lta' => $ctc_query->lta,
            'childedu' => $ctc_query->childedu,
            'anualgrs' => $ctc_query->anualgrs,
            'gratuity' => $ctc_query->gratuity,
            'emplyerPF' => $ctc_query->emplyerPF,
            'emplyerESIC' => $ctc_query->emplyerESIC,
            'medical' => $ctc_query->medical,
            'total_ctc' => $ctc_query->total_ctc,
        ]);

        if ($SendCTC) {
            return response()->json(['success' => 'Data Sent Successfully']);
        } else {
            return response()->json(['error' => 'Data Not Sent']);
        } */
    }
}
