<?php

namespace App\Helpers;

use Hamcrest\Core\IsNull;
use Illuminate\Support\Facades\DB;

if (!function_exists('getFullName')) {

	/**
	 * Get full name by retrieving employee details
	 *
	 * @param integer|null $employeeId The ID of the employee. Null values return empty strings.
	 * @return string The full name of the employee or empty string if no match was found.
	 */
	function getFullName($employeeId): string
	{
		// if null, return empty string to avoid unnecessary database query
		if ($employeeId === null) {
			return '';
		}

		// if 1, return "Admin" to avoid database query altogether
		if ($employeeId === 1) {
			return 'Admin';
		}

		// use Laravel's Query Builder to retrieve employee data more efficiently
		$employee = DB::table('master_employee')->select('Title', 'Fname', 'Sname', 'Lname')->where('EmployeeID', $employeeId)->first();

		// if employee data not found, return empty string
		if ($employee === null) {
			return '';
		}

		// combine employee name fields into full name and return properly formatted
		$fullNameParts = array_filter([$employee->Title, $employee->Fname, $employee->Sname, $employee->Lname], function ($part) {
			return $part !== null && trim($part) !== "";
		});
		$fullName = ucwords(strtolower(implode(" ", $fullNameParts)));

		return $fullName;
	}
}

if (!function_exists('getFullNameByEmail')) {

    /**
     * Get full name by retrieving employee details
     *
     * @param integer|null $employeeId The ID of the employee. Null values return empty strings.
     * @return string The full name of the employee or empty string if no match was found.
     */
    function getFullNameByEmail($email): string
    {
        // if null, return empty string to avoid unnecessary database query
        if ($email === null || $email === '') {
            return '';
        }



        // use Laravel's Query Builder to retrieve employee data more efficiently
        $employee = DB::table('master_employee')->select('Title', 'Fname', 'Sname', 'Lname')->where('Email', $email)->first();

        // if employee data not found, return empty string
        if ($employee === null) {
            return '';
        }

        // combine employee name fields into full name and return properly formatted
        $fullNameParts = array_filter([$employee->Title, $employee->Fname, $employee->Sname, $employee->Lname], function ($part) {
            return $part !== null && trim($part) !== "";
        });
        $fullName = ucwords(strtolower(implode(" ", $fullNameParts)));

        return $fullName;
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

function getEmpIdByEmpCode($empCode)
{

	if ($empCode == null) {
		return "";
	} else {
		$query = DB::table('master_employee')->select("EmployeeID")->where('EmpCode', $empCode)->first();
		return $query->EmployeeID;
	}
}

function getEmployeeDesignation($empid)
{
	if (!$empid) {
		return '';
	}

	$query = DB::table('master_employee')
		->join('master_designation', 'master_designation.DesigId', '=', 'master_employee.DesigId')
		->select('DesigName')
		->where('EmployeeID', $empid)
		->first();

	return $query ? $query->DesigName : '';
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
		if (is_null($DepartmentCode)) {
			return '';
		} else {
			return $DepartmentCode->DepartmentCode;
		}
	}
}

function getDepartmentShortCode($DeptId)
{
	if ($DeptId == null) {
		return "";
	} else {
		$ShortCode = Db::table('master_department')->select('ShortCode')->where('DepartmentId', $DeptId)->first();
		if (is_null($ShortCode)) {
			return '';
		} else {
			return $ShortCode->ShortCode;
		}
	}
}

function getDepartment($DeptId)
{
	if ($DeptId == null) {
		return "";
	} else {
		$Department = Db::table('master_department')->select('DepartmentName')->where('DepartmentId', $DeptId)->first();
		if (is_null($Department)) {
			return '';
		} else {
			return $Department->DepartmentName;
		}
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
		if(is_null($DesigName)){
		    return "";
		}else{
		    return $DesigName->DesigName;
		}
		
	}
}

function getGradeValue($GradeId)
{
    if ($GradeId == null) {
        return "";
    } else {
        $GradeValue = Db::table('master_grade')->select('GradeValue')->where('GradeId', $GradeId)->first();
        if (is_null($GradeValue)) {
            return '';
        } else {
            return $GradeValue->GradeValue;
        }
    }
}

function getHQ($HqId)
{
    if ($HqId == null || $HqId == 0) {
        return "";
    } else {
        $HqName = Db::table('master_headquater')->select('HqName')->where('HqId', $HqId)->first();
        if (is_null($HqName)) {
            return '';
        } else {
            return $HqName->HqName;
        }
    }
}

function getStateCode($StateId)
{
	if ($StateId == null || $StateId == 0) {
		return "";
	} else {
		$StateCode = Db::table('states')->select('StateCode')->where('StateId', $StateId)->first();


		if (is_null($StateCode)) {
			return '';
		} else {
			return $StateCode->StateCode;
		}
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
		->where('CountryId', session('Set_Country'))
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
	if ($eid == null) {
		return "";
	} else {
		$Education = Db::table('master_education')->select('EducationName')->where('EducationId', $eid)->first();

		if (is_null($Education)) {
			return '';
		} else {
			return $Education->EducationName;
		}
	}
}

function getEducationCodeById($eid)
{
	if ($eid == null) {
		return "";
	} else {
		$Education = Db::table('master_education')->select('EducationCode')->where('EducationId', $eid)->first();

		if (is_null($Education)) {
			return '';
		} else {
			return $Education->EducationCode;
		}
	}
}

function getSpecializationbyId($sid)
{


	$query = DB::table('master_specialization')->select('Specialization')->where('SpId', $sid)->first();
	return $query->Specialization;
}

function getCollegeById($id)
{
	if ($id == null) {
		return "";
	} else {
		$institute = DB::table('master_institute')->select('InstituteName')->where('InstituteId', $id)->first();
		if (is_null($institute)) {
			return '';
		} else {
			return $institute->InstituteName;
		}
	}
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
	if ($StateId == null || $StateId == 0) {
		return "";
	} else {
		$StateCode = Db::table('master_state')->select('StateCode')->where('StateId', $StateId)->first();
			if (is_null($StateCode)) {
			return '';
		} else {
			return $StateCode->StateCode;
		}
	
	}
}

function CheckCommControl($Id)
{
	$sql = Db::table('communication_control')->select('is_active')->where('id', $Id)->first();
	if ($sql->is_active == '1') {
		return '1';
	} else {
		return '0';
	}
}



function has_permission($resultArray, $pageName)
{
    foreach ($resultArray as $key => $value) {
        if ($value['PageName'] == $pageName) {
            return true;
        }
    }
    return false;
}

function CheckDuplicate($Fname, $Phone, $Email, $Dob, $FatherName)
{
	$sql  = DB::select("SELECT COUNT(*) as total FROM `jobcandidates` WHERE  (`Phone` = '$Phone')   or (`Email` = '$Email' )or ('FName' = '$Fname' and 'DOB' = '$Dob' and 'FatherName' = '$FatherName')");
	$count = $sql[0]->total;
	return $count;
}

function getStateIdByName($StateName)
{
	$state = strtoupper($StateName);
	$StateId = DB::table('states')->select('StateId')->where('StateName', $state)->first();
	if (is_null($StateId)) {
		return 0;
	} else {
		return $StateId->StateId;
	}
}
if (!function_exists('CheckReportee')) {
function CheckReportee($empid)
{
    $isReportee = DB::table('master_employee')
        ->where('RepEmployeeID', $empid)
        ->exists();

    return $isReportee ? '1' : '0';
}
}