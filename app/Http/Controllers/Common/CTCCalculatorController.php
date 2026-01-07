<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CTCCalculatorController extends Controller
{
    public function ctc_calculator()
    {
        try {
            $company_list = DB::table("core_company")->where('id',11)->orderBy('company_code', 'desc')->pluck("company_code", "id");
            return view('ctc_calculator.index', compact('company_list'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function calculate_ctc(Request $request)
    {
        try {
            $request->validate([
                'target_fixed_ctc' => 'required|numeric|min:1',
                'Company' => 'required',
                'MW' => 'required'
            ]);

            $target_fixed_ctc = $request->target_fixed_ctc;
            $Company = $request->Company;
            $MW = $request->MW;
            $Communication_Allowance = $request->Communication_Allowance ?? 'N';
            $Vehicle_Allowance = $request->Vehicle_Allowance ?? 'N';
            $VehiclePolicy = $request->VehiclePolicy ?? null;
            $Grade = $request->Grade ?? null;

            // Tolerance level
            $tolerance = 10;

            // Initial gross monthly salary
            $grsM_salary = 11000;

            // Binary search parameters
            $min_gross = 10000;
            $max_gross = 40000; // Set a reasonable upper limit
            $iteration = 0;
            $max_iterations = 100; // Prevent infinite loop

            $best_gross = $grsM_salary;
            $best_diff = PHP_INT_MAX;

            // Binary search to find the gross salary that matches target fixed CTC
            while ($iteration < $max_iterations) {
                $grsM_salary = round(($min_gross + $max_gross) / 2);
			
                // Calculate CTC with current gross salary
                $result = $this->calculateCTCComponents($grsM_salary, $Company, $MW, $Communication_Allowance, $Vehicle_Allowance, $VehiclePolicy, $Grade);

                $calculated_fixed_ctc = $result['fixed_ctc'];
                $difference = $target_fixed_ctc - $calculated_fixed_ctc;

                // Track the best result
                if (abs($difference) < abs($best_diff)) {
                    $best_diff = $difference;
                    $best_gross = $grsM_salary;
                }

                // Check if within tolerance
                if (abs($difference) <= $tolerance) {
                    break;
                }

                // Adjust search range
                if ($calculated_fixed_ctc < $target_fixed_ctc) {
                    $min_gross = $grsM_salary + 1;
                } else {
                    $max_gross = $grsM_salary - 1;
                }

                // Check if search range is too narrow
                if ($max_gross - $min_gross < 1) {
                    $grsM_salary = $best_gross;
                    break;
                }

                $iteration++;
            }

            // Calculate final CTC with the found gross salary
            $final_result = $this->calculateCTCComponents($grsM_salary, $Company, $MW, $Communication_Allowance, $Vehicle_Allowance, $VehiclePolicy, $Grade);

            return response()->json([
                'status' => 200,
                'data' => $final_result,
                'iterations' => $iteration,
                'difference' => round($target_fixed_ctc - $final_result['fixed_ctc'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Error calculating CTC: ' . $e->getMessage()
            ], 400);
        }
    }

    private function calculateCTCComponents($grsM_salary, $Company, $MW, $Communication_Allowance, $Vehicle_Allowance, $VehiclePolicy, $Grade)
    {
        $get_bonus = DB::table('minimum_wage_master')
            ->where('Category', $MW)
            ->where('CompanyId', $Company)
            ->orderByDesc('CrDate')
             ->first();
        

        if (!$get_bonus) {
            throw new \Exception('Minimum wage data not found for the selected category and company.');
        }

        $bonus = 0;
        $bonusM = 0;
        $basic = 0;
        $hra = 0;
        $special = 0;
        $pf = 0;
        $employer_pf = 0;
        $net_monthly = 0;
        $anualgrs = 0;
        $gratuity = 0;
        $medical = 0;
        $emplyESIC = 0;
        $emplyerESIC = 0;
        $variable_pay = 0;

        // Condition-based CTC calculation
        if ($grsM_salary <= 18000) {
            // Condition 1: Gross Monthly Salary <= 18000

            // Calculate bonus from minimum wage table
            if (in_array(date("m"), ['01', '02', '03', '10', '11', '12'])) {
                $bonus = $get_bonus->PerMonthOct;
            } else {
                $bonus = $get_bonus->PerMonthApr;
            }

            if ($bonus > 0) {
                $bonusTable = [
                    11 => 0.20
                ];
                $bonusM = round($bonus * ($bonusTable[$Company] ?? 0));
            }

            // Basic = Gross Monthly - Bonus
            $basic = round($grsM_salary - $bonusM);
            $hra = 0;
            $special = 0;

            // Employee PF = (basic + special) * 12%
            $pf = round(($basic + $special) * 0.12);

            // Employer PF = (basic + special) * 12% * 12
            $employer_pf = round(($basic + $special) * 0.12 * 12);

            // Employee ESIC
            $emplyESIC = round(($basic + $special) * 0.75 / 100);

            // Employer ESIC
            $emplyerESIC = round(($basic + $special) * 3.25 / 100 * 12);

            // Medical
            if (($basic + $special) > 21000) {
                    $medical = 15000;
                
            } else {
                $medical = 3000;
            }

        } elseif ($grsM_salary > 18000 && $grsM_salary < 21000) {
            // Condition 2: Gross Monthly Salary > 18000 and < 21000

            // Calculate bonus from minimum wage table (same as Condition 1)
            if (in_array(date("m"), ['01', '02', '03', '10', '11', '12'])) {
                $bonus = $get_bonus->PerMonthOct;
            } else {
                $bonus = $get_bonus->PerMonthApr;
            }

            if ($bonus > 0) {
                $bonusTable = [
                    11 => 0.20
                ];
                $bonusM = round($bonus * ($bonusTable[$Company] ?? 0));
            }

            $basic = 15000;

            // HRA: Maximum up to 40% of basic, but ensure basic + bonus + hra <= gross
            $maxHra = round($basic * 0.40);
            $remainingAfterBasicBonus = $grsM_salary - $basic - $bonusM;
            $hra = min($maxHra, max(0, $remainingAfterBasicBonus));

            // Special: Remaining amount
            $special = round(max(0, $grsM_salary - ($basic + $bonusM + $hra)));

            // Fixed PF
            $pf = 1800;
            $employer_pf = 21600;

            // Employee ESIC
            $emplyESIC = round(($basic + $special) * 0.75 / 100);

            // Employer ESIC
            $emplyerESIC = round(($basic + $special) * 3.25 / 100 * 12);

            // Medical
            if (($basic + $special) > 21000) {
               
                    $medical = 15000;
               
            } else {
                $medical = 3000;
            }

        } elseif ($grsM_salary >= 21000 && $grsM_salary <= 42000) {
            // Condition 3: Gross Monthly Salary >= 21000 and <= 42000

            $basic = 21050;
            $bonusM = 0;

            // HRA: Maximum up to 40% of basic, but ensure basic + bonus + hra <= gross
            $maxHra = round($basic * 0.40);
            $remainingAfterBasicBonus = $grsM_salary - $basic - $bonusM;
            $hra = min($maxHra, max(0, $remainingAfterBasicBonus));

            // Special: Remaining amount
            $special = round(max(0, $grsM_salary - ($basic + $bonusM + $hra)));

            // Fixed PF
            $pf = 1800;
            $employer_pf = 21600;

            // No ESIC for salary >= 21000
            $emplyESIC = 0;
            $emplyerESIC = 0;

            // Medical
         
                $medical = 15000;
           

        } else {
            // Condition 4: Gross Monthly Salary > 42000

            $basic = round($grsM_salary * 0.5); // 50% of gross
            $bonusM = 0;

            // HRA: Maximum up to 40% of basic, but ensure basic + bonus + hra <= gross
            $maxHra = round($basic * 0.40);
            $remainingAfterBasicBonus = $grsM_salary - $basic - $bonusM;
            $hra = min($maxHra, max(0, $remainingAfterBasicBonus));

            // Special: Remaining amount
            $special = round(max(0, $grsM_salary - ($basic + $bonusM + $hra)));

            // Fixed PF
            $pf = 1800;
            $employer_pf = 21600;

            // No ESIC for salary > 21000
            $emplyESIC = 0;
            $emplyerESIC = 0;

            // Medical
           
                $medical = 15000;
        
        }

        // Common calculations for all conditions
        $anualgrs = round($grsM_salary * 12);
        $net_monthly = round($grsM_salary - ($pf + $emplyESIC));
        $gratuity = round((($basic + $special) * 15) / 26);
        $fixed_ctc = round($anualgrs + $gratuity + $employer_pf + $emplyerESIC + $medical);

        // Variable pay
        if ($Company == 1) {
            $variable_pay = round($anualgrs * 5 / 100);
        }

        $total_ctc = $fixed_ctc + $variable_pay;

        // Car allowance calculation
        $car_allowance = 0;
        if ($VehiclePolicy == 13 && $Grade) {
            $policy_conn = DB::connection('mysql3');
            $car_allowance_data = $policy_conn
                ->table('hrm_master_eligibility_policy_tbl' . $VehiclePolicy)
                ->where('GradeId', $Grade)
                ->first();
            if ($car_allowance_data != null) {
                $car_allowance = intval($car_allowance_data->Fn36) * 12;
            }
        }

        $vehicle_allowance_amount = 0;
        if ($Vehicle_Allowance == 'Y') {
            $vehicle_allowance_amount = 24000;
        }

        $Communication_Allowance_Amount = 0;
        if ($Company == 11 && $Communication_Allowance == 'Y') {
            $Communication_Allowance_Amount = 4800;
        }

        $total_gross_ctc = $total_ctc + $car_allowance + $Communication_Allowance_Amount + $vehicle_allowance_amount;

        return [
            'grsM_salary' => round($grsM_salary),
            'bonus' => round($bonusM),
            'basic' => round($basic),
            'hra' => round($hra),
            'special_alw' => round($special),
            'emplyPF' => round($pf),
            'emplyerPF' => round($employer_pf),
            'netMonth' => round($net_monthly),
            'anualgrs' => round($anualgrs),
            'gratuity' => round($gratuity),
            'emplyESIC' => round($emplyESIC),
            'emplyerESIC' => round($emplyerESIC),
            'medical' => round($medical),
            'fixed_ctc' => round($fixed_ctc),
            'performance_pay' => round($variable_pay),
            'total_ctc' => round($total_ctc),
            'communication_allowance_amount' => $Communication_Allowance_Amount,
            'vehicle_allowance_amount' => $vehicle_allowance_amount,
            'car_allowance_amount' => $car_allowance,
            'total_gross_ctc' => $total_gross_ctc
        ];
    }
}
