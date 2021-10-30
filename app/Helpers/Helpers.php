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
		$CompanyCode = Db::table('master_company')->select('CompanyCode')->where('CompanyId', $companyId)->first();
		return $CompanyCode->CompanyCode;
	}

	function getDepartmentCode($DeptId)
	{
		$DepartmentCode = Db::table('master_department')->select('DepartmentCode')->where('DepartmentId', $DeptId)->first();
		return $DepartmentCode->DepartmentCode;
	}

	function getDepartment($DeptId)
	{
		$Department = Db::table('master_department')->select('DepartmentName')->where('DepartmentId', $DeptId)->first();
		return $Department->DepartmentName;
	}

	function getDesignationCode($DesigId)
	{
		$DesigCode = Db::table('master_designation')->select('DesigCode')->where('DesigId', $DesigId)->first();
		return $DesigCode->DesigCode;
	}

	function getDesignation($DesigId)
	{
		$DesigName = Db::table('master_designation')->select('DesigName')->where('DesigId', $DesigId)->first();
		return $DesigName->DesigName;
	}

	function getGradeValue($GradeId)
	{
		$GradeValue = Db::table('master_grade')->select('GradeValue')->where('GradeId', $GradeId)->first();
		return $GradeValue->GradeValue;
	}

	function getHQ($HqId)
	{
		$HqName = Db::table('master_headquater')->select('HqName')->where('HqId', $HqId)->first();
		return $HqName->HqName;
	}

	function getStateCode($StateId)
	{
		$StateCode = Db::table('states')->select('StateCode')->where('StateId', $StateId)->first();
		return $StateCode->StateCode;
	}

	function getStateName($StateId)
	{
		$StateName = Db::table('states')->select('StateName')->where('StateId', $StateId)->first();
		return $StateName->StateName;
	}

	function getDistrictName($DistrictId)
	{
		$DistrictName = Db::table('master_district')->select('DistrictName')->where('DistrictId', $DistrictId)->first();
		if (is_null($DistrictName)) {
			return '';
		} else {
			return $DistrictName->DistrictName;
		}
	}

	function convertData($body_content)
	{

		$body_content = stripslashes($body_content);
		$body_content = addslashes($body_content);
		return $body_content;
	}

	function ActiveMRFCount($Uid)
	{
		$sql = DB::table('manpowerrequisition')
			->where('Status', 'Approved')
			->where('Status', '!=', 'Close')
			->where('Allocated', $Uid)
			->get();
		return $sql->count();
	}

	function CheckReplacementMRF($empid)
	{
		$sql = Db::table('manpowerrequisition')->select('MRFId')->where('RepEmployeeID', $empid)->first();

		if (is_null($sql)) {
			return '0';
		} else {
			return '1';
		}
	}

	function CheckJobPostCreated($mrfid)
	{
		$sql = Db::table('jobpost')->select('JPId')->where('MRFId', $mrfid)->first();

		if (is_null($sql)) {
			return '0';
		} else {
			return '1';
		}
	}

	function GetJobPostId($mrfid)
	{
		$sql = Db::table('jobpost')->select('JPId')->where('MRFId', $mrfid)->first();

		if (is_null($sql)) {
			return '0';
		} else {
			return $sql->JPId;
		}
	}

	function getEducationById($eid)
	{
		$EducationCode = DB::table('master_education')->select('EducationCode')->where('EducationId', $eid)->first();
		return $EducationCode->EducationCode;
	}

	function getSpecializationbyId($sid)
	{
		$Specialization = DB::table('master_specialization')->select('Specialization')->where('SpId', $sid)->first();
		return $Specialization->Specialization;
	}

	function getCollegeById($id)
	{
		$institute = DB::table('master_institute')->select('InstituteName')->where('InstituteId', $id)->first();
		return $institute->InstituteName;
	}
	function getCollegeCode($id)
	{
		$institute = DB::table('master_institute')->select('InstituteCode')->where('InstituteId', $id)->first();
		return $institute->InstituteCode;
	}

	function SendOTP($mobile, $otp)
	{
		$username = "developerinvnr@gmail.com";
		$hash = "736397e8c20036f67d304d4d8ee316720a93c9d9d83046cbb453303194086efa";
		$test = "0";
		$sender = "RECVNR";

		$message = "Your Verification Code is: $otp -vnr";
		$data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $mobile . "&test=" . $test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);

		if (strpos($result, 'failure') !== false) {
			return "failure";
		} else {
			return "success";
		}
		curl_close($ch);
	}

	function CheckJobPostExpiry($jpid)
	{
		$sql = Db::table('jobpost')->select('LastDate')->where('JobPostType', 'Campus')->where('JPId', $jpid)->first();

		$LastDate = $sql->LastDate;
		if ($LastDate < date('Y-m-d')) {
			return 'expired';
		} else {
			return 'notexpired';
		}
	}
}
