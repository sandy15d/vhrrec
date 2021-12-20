<?php

namespace App\Helpers;

use Hamcrest\Core\IsNull;
use Illuminate\Support\Facades\DB;

if (!function_exists('getFullName')) {

	function getFullName($empid)
	{
		if ($empid == null) {
			return "";
		} else {
			if ($empid == 1) {
				return "Admin";
			} else {
				$Name = DB::table('master_employee')->select(DB::raw("CONCAT(master_employee.Fname,' ',master_employee.Lname) AS full_name"))->where('EmployeeID', $empid)->first();
				return $Name->full_name;
			}
		}
	}

	function getEmailID($empid)
	{
		if ($empid == null) {
			return "";
		} else {
			$Name = DB::table('users')->select("email")->where('id', $empid)->first();
			return $Name->email;
		}
	}

	function getEmployeeEmailId($empid)
	{
		if ($empid == null) {
			return "";
		} else {
			$Name = DB::table('master_employee')->select("Email")->where('EmployeeID', $empid)->first();
			return $Name->Email;
		}
	}


	function getCompanyCode($companyId)
	{
		if ($companyId == null) {
			return "";
		} else {
			$CompanyCode = Db::table('master_company')->select('CompanyCode')->where('CompanyId', $companyId)->first();
			return $CompanyCode->CompanyCode;
		}
	}
	function getCompanyName($companyId)
	{
		if ($companyId == null) {
			return "";
		} else {
			$CompanyName = Db::table('master_company')->select('CompanyName')->where('CompanyId', $companyId)->first();
			return $CompanyName->CompanyName;
		}
	}

	function getDepartmentCode($DeptId)
	{
		if ($DeptId == null) {
			return "";
		} else {
			$DepartmentCode = Db::table('master_department')->select('DepartmentCode')->where('DepartmentId', $DeptId)->first();
			return $DepartmentCode->DepartmentCode;
		}
	}

	function getDepartment($DeptId)
	{
		if ($DeptId == null) {
			return "";
		} else {
			$Department = Db::table('master_department')->select('DepartmentName')->where('DepartmentId', $DeptId)->first();
			return $Department->DepartmentName;
		}
	}

	function getDesignationCode($DesigId)
	{
		if ($DesigId == null) {
			return "";
		} else {
			$DesigCode = Db::table('master_designation')->select('DesigCode')->where('DesigId', $DesigId)->first();
			return $DesigCode->DesigCode;
		}
	}

	function getDesignation($DesigId)
	{
		if ($DesigId == null) {
			return "";
		} else {
			$DesigName = Db::table('master_designation')->select('DesigName')->where('DesigId', $DesigId)->first();
			return $DesigName->DesigName;
		}
	}

	function getGradeValue($GradeId)
	{
		if ($GradeId == null) {
			return "";
		} else {
			$GradeValue = Db::table('master_grade')->select('GradeValue')->where('GradeId', $GradeId)->first();
			return $GradeValue->GradeValue;
		}
	}

	function getHQ($HqId)
	{
		if ($HqId == null) {
			return "";
		} else {
			$HqName = Db::table('master_headquater')->select('HqName')->where('HqId', $HqId)->first();
			return $HqName->HqName;
		}
	}

	function getStateCode($StateId)
	{
		if ($StateId == null) {
			return "";
		} else {
			$StateCode = Db::table('states')->select('StateCode')->where('StateId', $StateId)->first();
			return $StateCode->StateCode;
		}
	}

	function getStateName($StateId)
	{
		if ($StateId == null) {
			return "";
		} else {
			$StateName = Db::table('states')->select('StateName')->where('StateId', $StateId)->first();
			return $StateName->StateName;
		}
	}

	function getDistrictName($DistrictId)
	{
		if ($DistrictId == null) {
			return "";
		} else {
			$DistrictName = Db::table('master_district')->select('DistrictName')->where('DistrictId', $DistrictId)->first();
			if (is_null($DistrictName)) {
				return '';
			} else {
				return $DistrictName->DistrictName;
			}
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


		$query = DB::table('master_specialization')->select('Specialization')->where('SpId', $sid)->first();
		return $query->Specialization;
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

	function ResumeSourceCount($JPId)
	{
		$sql =	DB::table('jobapply')
			->Join('master_resumesource', 'jobapply.ResumeSource', '=', 'master_resumesource.ResumeSouId')
			->where('jobapply.JPId', $JPId)
			->select(DB::raw('COUNT(jobapply.JAId) AS Applied'), 'master_resumesource.ResumeSource')
			->groupBy('jobapply.ResumeSource')
			->get();
		$x = '';
		foreach ($sql as $item) {
			$x .= '<span class="badge rounded-pill bg-warning text-dark" style="font-size:12px;">' . $item->ResumeSource . ':' . $item->Applied . '</span> ';
		}
		return $x;
	}

	function getResumeSourceById($id)
	{
		$ResumeSource = DB::table('master_resumesource')->select('ResumeSource')->where('ResumeSouId', $id)->first();
		return $ResumeSource->ResumeSource;
	}

	function getHqStateCode($StateId)
	{
		$StateCode = Db::table('master_state')->select('StateCode')->where('StateId', $StateId)->first();
		return $StateCode->StateCode;
	}
}
