<?php

namespace App\Helpers;

use Hamcrest\Core\IsNull;
use Illuminate\Support\Facades\DB;

if (!function_exists('getFullName')) {

	function getFullName($empid)
	{
		$Name = DB::table('master_employee')->select(DB::raw("CONCAT(master_employee.Fname,' ',master_employee.Lname) AS full_name"))->where('EmployeeID', $empid)->first();
		return $Name->full_name;
	}

	function getEmailID($empid)
	{
		$Name = DB::table('users')->select("email")->where('id', $empid)->first();
		return $Name->email;
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

	function getGradeValue($GradeId){
		$GradeValue = Db::table('master_grade')->select('GradeValue')->where('GradeId',$GradeId)->first();
		return $GradeValue->GradeValue;
	}

	function getHQ($HqId){
		$HqName = Db::table('master_headquater')->select('HqName')->where('HqId',$HqId)->first();
		return $HqName->HqName;
	}


	function getStateCode($StateId){
		$StateCode = Db::table('states')->select('StateCode')->where('StateId',$StateId)->first();
		return $StateCode->StateCode;
	}

	function getDistrictName($DistrictId){
		$DistrictName = Db::table('master_district')->select('DistrictName')->where('DistrictId',$DistrictId)->first();
		if(is_null($DistrictName)){
			return '';
		}else{
			return $DistrictName->DistrictName;
		}
	
	}

	function convertData($body_content) {
	
		$body_content = stripslashes($body_content);
	//	$body_content = htmlspecialchars($body_content);
		$body_content = addslashes($body_content);
		return $body_content;
	 } 

	 function ActiveMRFCount($Uid){
		 $sql =DB::table('manpowerrequisition')
		 ->where('Status','Approved')
		 ->where('Status','!=','Close')
		 ->where('Allocated',$Uid)
		 ->get();
		return $sql->count();
	 }

	 function CheckReplacementMRF($empid){
		$sql = Db::table('manpowerrequisition')->select('MRFId')->where('RepEmployeeID',$empid)->first();
		
		if(is_null($sql)){
			return '0';
		}else{
			return '1';
		}
		
	 }

	 function CheckJobPostCreated($mrfid){
		$sql = Db::table('jobpost')->select('JPId')->where('MRFId',$mrfid)->first();
		
		if(is_null($sql)){
			return '0';
		}else{
			return '1';
		}
		
	 }

}
