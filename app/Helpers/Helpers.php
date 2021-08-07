<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

if (!function_exists('getFullName')) {

	function getFullName($empid)
	{
		$Name = DB::table('master_employee')->select(DB::raw("CONCAT(master_employee.Fname,' ',master_employee.Lname) AS full_name"))->where('EmployeeID', $empid)->first();
		return $Name->full_name;
	}

	function getCompanyCode($companyId)
	{
		$CompanyCode = Db::table('master_company')->select('CompanyCode')->where('CompanyId',$companyId)->first();
		return $CompanyCode->CompanyCode;
	}

	function getDepartmentCode($DeptId){
		$DepartmentCode = Db::table('master_department')->select('DepartmentCode')->where('DepartmentId',$DeptId)->first();
		return $DepartmentCode->DepartmentCode;
	}

	function getDesignationCode($DesigId){
		$DesigCode = Db::table('master_designation')->select('DesigCode')->where('DesigId',$DesigId)->first();
		return $DesigCode->DesigCode;
	}

	function getStateCode($StateId){
		$StateCode = Db::table('states')->select('StateCode')->where('StateId',$StateId)->first();
		return $StateCode->StateCode;
	}

	function getDistrictName($DistrictId){
		$DistrictName = Db::table('master_district')->select('DistrictName')->where('DistrictId',$DistrictId)->first();
		return $DistrictName->DistrictName;
	}

	function convertData($body_content) {
	
		$body_content = stripslashes($body_content);
	//	$body_content = htmlspecialchars($body_content);
		$body_content = addslashes($body_content);
		return $body_content;
	 } 

}
