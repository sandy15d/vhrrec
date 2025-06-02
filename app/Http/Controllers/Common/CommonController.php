<?php

namespace App\Http\Controllers\Common;

use App\Models\master_mrf;
use App\Models\ThemeDetail;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\CandidateMail;
use App\Models\jobcandidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function App\Helpers\convertData;
use function App\Helpers\getCompanyCode;
use function App\Helpers\getDepartmentCode;

use function App\Helpers\getDesignationCode;
use function App\Helpers\getFullName;
use Citco\Carbon;
class CommonController extends Controller
{


    function setTheme(Request $request)
    {
        $ThemeStyle = $request->ThemeStyle;
        if ($ThemeStyle != '') {
            if ($ThemeStyle == 'lightmode') {
                $Style = 'light-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'darkmode') {
                $Style = 'dark-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'semidark') {
                $Style = 'semi-dark';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'minimaltheme') {
                $Style = 'minimal-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'sidebarcolor1') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor1';
            } elseif ($ThemeStyle == 'sidebarcolor2') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor2';
            } elseif ($ThemeStyle == 'sidebarcolor3') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor3';
            } elseif ($ThemeStyle == 'sidebarcolor4') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor4';
            } elseif ($ThemeStyle == 'sidebarcolor5') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor5';
            } elseif ($ThemeStyle == 'sidebarcolor6') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor6';
            } elseif ($ThemeStyle == 'sidebarcolor7') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor7';
            } elseif ($ThemeStyle == 'sidebarcolor8') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor8';
            }


            $data = array(
                'ThemeStyle' => $Style,
                'SidebarColor' => $SidebarColor,
                'UserId' => Auth::user()->id,
            );
            $query =  ThemeDetail::updateOrCreate(['UserId' => Auth::user()->id], $data);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                $request->session()->forget('ThemeStyle');
                $request->session()->forget('SidebarColor');
                $request->session()->put('ThemeStyle', $Style);
                $request->session()->put('SidebarColor', $SidebarColor);
                return response()->json(['status' => 200, 'msg' => 'New Theme has been successfully Applied.']);
            }
        }
    }

    public function getDesignation(Request $request)
    {
        $designation = DB::table("core_designation_department_mapping as d")->orderBy('de.designation_name', 'asc')
            ->join('core_designation as de', 'de.id', '=', 'd.designation_id')
            ->where("d.department_id", $request->DepartmentId)
            ->where("de.is_active", '1')
            ->pluck("de.id", "de.designation_name");
        return response()->json($designation);
    }

    public function getGrade(Request $request)
    {
        $company = $request->CompanyId;
        if ($company == 1) {
            $grade_list = DB::table("master_grade")->where('GradeStatus', 'A')->where('CompanyId', $company)->where('GradeId', '>=', '61')->orderBy('GradeValue', 'ASC')->pluck("GradeId", "GradeValue");
        } else {
            $grade_list = DB::table("master_grade")->where('GradeStatus', 'A')->where('CompanyId', $company)->orderBy('GradeValue', 'desc')->orderBy('GradeValue', 'ASC')->pluck("GradeId", "GradeValue");
        }

        return response()->json($grade_list);
    }

    public function getState()
    {
        $State = DB::table("states")->where('CountryId', 1)->orderBy('StateName', 'asc')->pluck("StateId", "StateName");
        return response()->json($State);
    }

    public function getState1(Request $request)
    {
        $State = DB::table("states")->where('CountryId', $request->CountryId)->orderBy('StateName', 'asc')->pluck("StateId", "StateName");
        return response()->json($State);
    }

    public function getDistrict(Request $request)
    {
        $District = DB::table("master_district")->orderBy('DistrictName', 'asc')
            ->where("StateId", $request->StateId)
            ->pluck("DistrictId", "DistrictName");
        return response()->json($District);
    }

    public function getHq(Request $request)
    {
        $Hq = DB::table("master_headquater")->orderBy('HqName', 'ASC')
            ->where("StateId", $request->StateId)
            ->pluck("HqId", "HqName");
        return response()->json($Hq);
    }

    public function getEducation()
    {
        $Education = DB::table("master_education")->orderBy('EducationName', 'asc')->pluck("EducationId", "EducationCode");
        return response()->json($Education);
    }

    public function getCollege()
    {
        $Education = DB::table("master_institute")->orderBy('InstituteName', 'asc')->pluck("InstituteId", "InstituteName");
        return response()->json($Education);
    }

    public function getCollege1(Request $request)
    {
        $Education = DB::table("master_institute")->join('states', 'states.StateId', '=', 'master_institute.StateId')->where('CountryId', $request->CountryId)->orderBy('InstituteName', 'asc')->pluck("InstituteId", "InstituteName");
        return response()->json($Education);
    }

    public function getSpecialization(Request $request)
    {
        $Specialization = DB::table("master_specialization")->orderBy('Specialization', 'asc')
            ->where("EducationId", $request->EducationId)
            ->pluck("SpId", "Specialization");
        return response()->json($Specialization);
    }


    public function getDepartment(Request $request)
    {
        $Department = DB::table("core_department")->orderBy('department_name', 'asc')
            
            ->where('is_active', '1')
            ->pluck("id", "department_name");
        return response()->json($Department);
    }

    public function getReportingManager(Request $request)
    {
        $Department = $request->DepartmentId;
        $Department1 = $Department - 1000;
        $employee = DB::table('master_employee')
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname," - ",VCode,EmpCode) AS FullName'))
            ->where('EmpStatus', 'A')
            ->where(function ($query) use ($Department, $Department1) {
                $query->where('DepartmentId', $Department)
                    ->orWhere('DepartmentId', $Department1);
            })
            ->orderBy('FullName', 'ASC')
            ->pluck("EmployeeID", "FullName");
        return response()->json($employee);
    }

    public function getEmpByCompany(Request $request)
    {
        $employee = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('CompanyId', $request->ComapnyId)
            ->where('EmpStatus', 'A')
            ->select('EmployeeID', DB::raw('CONCAT(EmpCode, "-", Fname, " ", Lname) AS FullName'))
            ->pluck("EmployeeID", "FullName");
        return response()->json($employee);
    }

    public function getResignedEmployee(Request $request)
    {

        $employee = DB::table('master_employee')->orderBy('FullName', 'ASC')
            ->where('DepartmentId', $request->DepartmentId)
            // ->where(function ($query) {
            //     $query->where('EmpStatus', '=', 'A')
            //         ->orWhere(function ($query) {
            //             $query->where('EmpStatus', '=', 'D')
            //                 ->where('DateOfSepration', '>=', '2021-01-01');
            //         });
            // })
            ->select('EmployeeID', DB::raw('CONCAT(Fname, " ", Lname," - ",VCode,EmpCode) AS FullName'))
            ->pluck("EmployeeID", "FullName");

        return response()->json($employee);
    }

    public function getResignedEmpDetail(Request $request)
    {
        $EmpId = $request->EmpId;
        $empDetails = DB::table('master_employee')
            ->leftJoin('master_designation', 'master_employee.DesigId', '=', 'master_designation.DesigId')
            ->leftJoin('master_headquater', 'master_employee.Location', '=', 'master_headquater.HqId')
            ->leftJoin('master_grade', 'master_employee.GradeId', '=', 'master_grade.GradeId')
            ->where('EmployeeID', $EmpId)
            ->select('master_designation.DesigName', 'master_headquater.HqName', 'master_grade.GradeValue', 'master_employee.CTC')
            ->get();
        return response()->json(['empDetails' => $empDetails]);
    }

    public function getAllDistrict()
    {
        $AllDistrict = DB::table("master_district")->orderBy('DistrictName', 'asc')->pluck("DistrictId", "DistrictName");
        return response()->json($AllDistrict);
    }

    public function getAllSP()
    {

        $Sp = DB::table("master_specialization")->orderBy('Specialization', 'asc')->pluck("Specialization", "SpId");


        return response()->json($Sp);
    }

    function getMRFDetails(Request $request)
    {
        $MRFId = $request->MRFId;
        $MRFDetails = master_mrf::find($MRFId);
        $LocationDetail = unserialize($MRFDetails->LocationIds);
        $UniversityDetail = unserialize($MRFDetails->EducationInsId);
        $KPDetail = unserialize($MRFDetails->KeyPositionCriteria);
        $EducationDetail = unserialize($MRFDetails->EducationId);
        return response()->json(['MRFDetails' => $MRFDetails, 'LocationDetails' => $LocationDetail, 'UniversityDetails' => $UniversityDetail, 'KPDetails' => $KPDetail, 'EducationDetails' => $EducationDetail]);
    }

    public function notificationMarkRead(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->notification_read = 1;
        $query = $notification->save();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Task has been allocated to recruiter successfully.']);
        }
    }


    public function markAllRead()
    {
        $query = DB::table('notification')->where('userid', '=', Auth::user()->id)->update(array('notification_read' => 1));
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200]);
        }
    }

    public function updateMRF(Request $request)
    {

        $State = $request->State;
        $City = $request->City;
        $ManPower = $request->ManPower;
        $Education = $request->Education;
        $Specialization = $request->Specialization;
        $KeyPosition = $request->KeyPosition;

        $locArray = array();
        if ($State != '') {
            for ($lc = 0; $lc < Count($State); $lc++) {
                $location = array(
                    "state" => $State[$lc],
                    "city" => $City[$lc] == '' ? '' : $City[$lc],
                    "nop" => $ManPower[$lc],
                );
                array_push($locArray, $location);
            }
        }
        $locArray_str = serialize($locArray);

        $Eduarray = array();
        if ($Education != '') {
            for ($count = 0; $count < Count($Education); $count++) {

                $e = array(
                    "e" => $Education[$count],
                    "s" => $Specialization[$count]
                );
                array_push($Eduarray, $e);
            }
        }
        $EduArray_str = serialize($Eduarray);

        $KpArray = array();
        if ($KeyPosition != '') {
            for ($i = 0; $i < Count($KeyPosition); $i++) {
                $KP = addslashes($KeyPosition[$i]);
                array_push($KpArray, $KP);
            }
        }

        $KpArray_str = serialize($KpArray);


        $UniversityArray = array();
        if ($request->University != '') {
            $UniversityArray = serialize($request->University);
        }

        $MRF = master_mrf::find($request->MRFId);
        $MRF->Type = $request->MRF_Type;
        $MRF->Reason = $request->Reason;
        $MRF->CompanyId = $request->Company;
        $MRF->DepartmentId = $request->Department;
        $MRF->DesigId = $request->Designation == '' ? 0 : $request->Designation;
        $MRF->Positions = array_sum($ManPower);
        $MRF->LocationIds = $locArray_str;
        $MRF->MinCTC = $request->MinCTC == '' ? NULL : $request->MinCTC;
        $MRF->MaxCTC = $request->MaxCTC == '' ? NULL : $request->MaxCTC;
        $MRF->Stipend = $request->Stipend == '' ? NULL : $request->Stipend;
        $MRF->DA = $request->da == '' ? NULL : $request->da;
        $MRF->TwoWheeler = $request->two_wheeler == '' ? NULL : $request->two_wheeler;
        $MRF->WorkExp = $request->WorkExp == '' ? NULL : $request->WorkExp;
        $MRF->Remarks = $request->Remark;
        $MRF->Info = convertData($request->JobInfo);
        $MRF->EducationId = $EduArray_str;
        $MRF->EducationInsId = $UniversityArray;
        $MRF->KeyPositionCriteria = $KpArray_str;
        $MRF->Tr_Frm_Date = $request->Tr_Frm_Date == '' ? NULL : $request->Tr_Frm_Date;
        $MRF->Tr_To_Date = $request->Tr_To_Date == '' ? NULL : $request->Tr_To_Date;
        $MRF->UpdatedBy = Auth::user()->id;
        $MRF->LastUpdated = now();
        $query = $MRF->save();
        $InsertId = $MRF->MRFId;
        if ($request->MRF_Type == 'SIP' || $request->MRF_Type == 'SIP_HrManual') {
            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/SIP/' . $InsertId . '-' . date('Y');
        } else {
            $jobCode = getCompanyCode($request->Company) . '/' . getDepartmentCode($request->Department) . '/' . getDesignationCode($request->Designation) . '/' . $InsertId . '-' . date('Y');
        }

        $query1 = DB::table('manpowerrequisition')
            ->where('MRFId', $InsertId)
            ->update(['JobCode' => $jobCode]);
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'MRF Status has been changed successfully.']);
        }
    }

    public function deleteMRF(Request $request)
    {
        $MRFId = $request->MRFId;
        $query = master_mrf::find($MRFId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'MRF data has been Deleted.']);
        }
    }

    public function getMRFByDepartment(Request $request)
    {
        $JobCode = DB::table("jobpost")->orderBy('JobCode', 'asc')
            ->where("DepartmentId", $request->DepartmentId)
            ->where('Status', 'Open')
            ->pluck("JPId", "JobCode");
        return response()->json($JobCode);
    }
    public function getCandidateName(Request $request)
    {
        $sql = jobcandidate::find($request->JCId);
        return $sql->FName;
    }

    public function sendMailToCandidate(Request $request)
    {
        $RId = Auth::user()->id;
        $Recruiter = getFullName($RId);
        $details = [
            "subject" => $request->Subject,
            "Candidate" => $request->CandidateName,
            "Message" => $request->eMailMsg,
            "Recruiter" => $Recruiter
        ];
        Mail::to($request->eMailId)->send(new CandidateMail($details));

        /*  if (count(Mail::failures()) > 0) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Mail has been sent successfully.']);
        } */
        return response()->json(['status' => 200, 'msg' => 'Mail has been sent successfully.']);
    }

    public function changePassword()
    {
        return view('common.changePassword');
    }

    public function passwordChange(Request $request)
    {
        $query = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['password' => bcrypt($request->new_password)]);
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Password has been changed successfully.']);
        }
    }


    public function upcoming_interview()
    {
        return view('common.upcoming_interview');
    }
    
    public function candidate_association(Request $request)
    {
        $MRFId = base64_decode($_GET['mrf']);
        $resume_list = DB::table('master_resumesource')->where([['Status', 'A'], ['ResumeSouId', '!=', '7']])->pluck('ResumeSource', 'ResumeSouId');
        $mrf = DB::table('manpowerrequisition as mrf')->selectRaw('ROW_NUMBER() OVER (ORDER BY mrf.MRFId) AS `S.No`')
            ->select('ja.Department', 'mrf.JobCode', 'md.DepartmentName', 'jp.Title', 'mrf.MRFId')
            ->selectRaw('COUNT(DISTINCT ja.JAId) AS `Total`')
            ->selectRaw('(
                    SELECT SUM(CASE WHEN ja.Status IS NOT NULL THEN 1 ELSE 0 END)
                     FROM jobapply AS ja
                     WHERE ja.JPId = jp.JPId
                    ) AS `HR_Screening`')
            ->selectRaw('(
            SELECT SUM(CASE WHEN ja.FwdTechScr = "Yes" THEN 1 ELSE 0 END)
            FROM jobapply AS ja
            WHERE ja.JPId = jp.JPId
            ) AS `Technical_Screening`')
            ->selectRaw('SUM(CASE WHEN s.InterAtt = "Yes" THEN 1 ELSE 0 END) AS `Interviewed`')
            ->selectRaw('SUM(CASE WHEN s.IntervStatus = "Selected" OR sr.IntervStatus2 = "Selected" THEN 1 ELSE 0 END) AS `Selected`')
            ->selectRaw('SUM(CASE WHEN ob.OfferLetterSent = "Yes" THEN 1 ELSE 0 END) AS `Offered`')
            ->selectRaw('SUM(CASE WHEN ob.Answer = "Accepted" THEN 1 ELSE 0 END) AS `Accepted`')
            ->selectRaw('SUM(CASE WHEN cd.Joined = "Yes" THEN 1 ELSE 0 END) AS `Joined`')
            ->selectRaw('SUM(IF(ob.Answer = "Accepted" AND cd.Joined IS NULL, 1, 0)) AS Yet_to_Joined')
            ->leftJoin('master_department as md', 'md.DepartmentId', 'mrf.DepartmentId')
            ->leftJoin('jobpost AS jp', 'jp.MRFId', '=', 'mrf.MRFId')
            ->leftJoin('jobapply AS ja', 'ja.JPId', '=', 'jp.JPId')
            ->leftJoin('screening AS s', 's.JAId', '=', 'ja.JAId')
            ->leftJoin('screen2ndround AS sr', 'sr.ScId', '=', 's.ScId')
            ->leftJoin('offerletterbasic AS ob', 'ob.JAId', '=', 'ja.JAId')
            ->leftJoin('candjoining AS cd', 'cd.JAId', '=', 'ja.JAId')
            ->where('mrf.MRFId', $MRFId)->first();
        $education_list = DB::table('master_education')->pluck('EducationCode', 'EducationId');
        $candidate_list = [];
        $filter = $request->get('filter');
        $usersQuery = master_mrf::query()
            ->select('jobcandidates.*', 'jobapply.JAId', 'jobapply.ApplyDate', 'jobapply.ResumeSource', 'jobapply.SLDPT',
                'jobapply.Status as hr_screening_status', 'jobapply.RejectRemark as hr_screening_remark', 'jobapply.Type',
                'jobapply.SelectedBy as hr_screening_by', 'jobapply.FwdTechScr', 'screening.ScreeningBy as tech_screening_by', 'screening.ScreenStatus as tech_screening_status',
                'screening.screening_remark', 'screening.IntervStatus'
            )
            ->leftJoin('jobpost', 'manpowerrequisition.MRFId', '=', 'jobpost.MRFId')
            ->join('jobapply', 'jobapply.JPId', '=', 'jobpost.JPId')
            ->leftJoin('screening', 'screening.JAId', 'jobapply.JAId')
            ->leftJoin('screen2ndround', 'screen2ndround.ScId', 'screening.ScId')
            ->join('jobcandidates', 'jobapply.JCId', '=', 'jobcandidates.JCId')
            ->leftJoin('offerletterbasic', 'offerletterbasic.JAId', 'jobapply.JAId')
            ->leftJoin('candjoining', 'candjoining.JAId', '=', 'jobapply.JAId')
            ->where('manpowerrequisition.MRFId', $MRFId)
            ->groupBy('jobapply.JAId');
        $Gender = $request->get('Gender');
        if ($Gender != '') {
            $usersQuery = $usersQuery->where('jobcandidates.Gender', $Gender);
        }
        $Type = $request->get('Type');
        if ($Type != '') {
            $usersQuery = $usersQuery->where('jobapply.Type', $Type);
        }
        $Source = $request->get('Source');
        if ($Source != '') {
            $usersQuery = $usersQuery->where('jobapply.ResumeSource', $Source);
        }
        if ($filter === 'total') {
            $Hr_Screening_Perform = $request->get('Hr_Screening_Perform');
            $candidate_list = $usersQuery;
            if ($Hr_Screening_Perform != '') {
                if ($Hr_Screening_Perform == 'Yes') {
                    $candidate_list = $candidate_list->whereNotNull('jobapply.Status');
                }
                if ($Hr_Screening_Perform == 'No') {
                    $candidate_list = $candidate_list->whereNull('jobapply.Status');
                }

            }
            $candidate_list = $usersQuery->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'total']);
        } elseif ($filter === 'hr_screening') {
            $HR_Scr_Status = $request->get('HR_Scr_Status');
            $statusMapping = [
                'Selected' => ['Selected'],
                'Rejected' => ['Rejected', 'Irrelevant'],
            ];

            $candidate_list = $usersQuery
                ->selectRaw('(CASE WHEN jobapply.Status = "Selected" THEN "Selected" ELSE "Rejected" END) AS `candidate_status`');
            if ($HR_Scr_Status != '') {
                $filteredStatus = $statusMapping[$HR_Scr_Status] ?? [];
                $candidate_list = $candidate_list->whereIn('jobapply.Status', $filteredStatus);
            }

            $candidate_list = $candidate_list
                ->whereNotNull('jobapply.Status')
                ->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'hr_screening']);
        } elseif ($filter === 'tech_screening') {
            $Tech_Scr_Status = $request->get('Tech_Scr_Status');

            $candidate_list = $usersQuery
                ->selectRaw('(CASE WHEN screening.ScreenStatus = "Shortlist" THEN "Selected" ELSE "Rejected" END) AS `candidate_status`')
                ->where('jobapply.FwdTechScr', 'Yes');
            if ($Tech_Scr_Status != '') {
                if ($Tech_Scr_Status == 'Selected') {
                    $candidate_list = $candidate_list->where('screening.ScreenStatus', 'Shortlist');
                } elseif ($Tech_Scr_Status == 'Rejected') {
                    $candidate_list = $candidate_list->where('screening.ScreenStatus', 'Reject');
                }

            }
            $candidate_list = $candidate_list->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'tech_screening']);
        } elseif ($filter === 'interviewed') {
            $Interview_Status = $request->get('Interview_Status');
            $candidate_list = $usersQuery
                ->selectRaw('(CASE WHEN screening.IntervStatus = "Selected" OR screen2ndround.IntervStatus2 = "Selected" THEN "Selected" ELSE "Rejected" END) AS `candidate_status`')
                ->where('screening.InterAtt', 'Yes');

            if ($Interview_Status != '') {
                if ($Interview_Status == 'Selected') {
                    $candidate_list = $candidate_list->where(function ($query) {
                        $query->where('screening.IntervStatus', 'Selected')
                            ->orWhere('screen2ndround.IntervStatus2', 'Selected');
                    });
                } elseif ($Interview_Status == 'Rejected') {
                    $candidate_list = $candidate_list->where(function ($query) {
                        $query->where('screening.IntervStatus', 'Reject')
                            ->orWhere('screen2ndround.IntervStatus2', 'Reject');
                    });
                }
            }

            $candidate_list = $candidate_list->paginate(10);

            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'interviewed']);
        } elseif ($filter === 'selected') {
            $candidate_list = $usersQuery
                ->where(function ($query) {
                    $query->where('screening.IntervStatus', 'Selected')
                        ->orWhere('screen2ndround.IntervStatus2', 'Selected');
                })
                ->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'selected']);
        } elseif ($filter === 'offered') {
            $candidate_list = $usersQuery
                ->where('offerletterbasic.OfferLetterSent', 'Yes')
                ->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'offered']);
        } elseif ($filter === 'accepted') {
            $candidate_list = $usersQuery
                ->where('offerletterbasic.Answer', 'Accepted')
                ->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'accepted']);
        } elseif ($filter === 'joined') {
            $candidate_list = $usersQuery
                ->where('candjoining.Joined', 'Yes')
                ->paginate(10);
            $candidate_list->appends(['mrf' => $_GET['mrf'], 'filter' => 'joined']);
        }


        return view('common.candidate_association', compact('mrf', 'candidate_list', 'education_list', 'resume_list'));
    }

    public function suitable_candidate(Request $request)
    {
        $JCId = $request->SuitableJCId;
        if ($request->suitable_department != null) {
            $Suitable_For = implode(', ', $request->suitable_department);
        } else {
            $Suitable_For = '';
        }

        $Suitable_Remark = $request->suitable_remark;
        $Irrelevant_Candidate = $request->Irrelevant_Candidate;
        $query = jobcandidate::find($JCId);
        $query->Irrelevant_Candidate = $Irrelevant_Candidate;
        $query->Suitable_For = $Suitable_For;
        $query->Suitable_Remark = $Suitable_Remark;
        $query->ProfileViewed = 'Y';
        $query->Suitable_Chk_Date = now();
        $query->Suitable_Chk_By = Auth::user()->id;
        $query->save();
        if ($query) {
            return response()->json(['status' => 200, 'msg' => 'Save Changes Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }

    }

    public function sldpt_process(Request $request)
    {
        $JAId = $request->JAId;

        $query = jobapply::find($JAId);

        $JPId = $query->JPId;


        $JCId = $query->JCId;


        $query->SLDPT = 'Y';
        $query->SLDPT_By = Auth::user()->id;
        $query->SLDPT_Date = now();
        $query->save();

        $jobpost = jobpost::find($JPId);
        $job_code = $jobpost->JobCode;

        $candidate = jobcandidate::find($JCId);
        $Name = implode(' ', [$candidate->FName, $candidate->LName]);
        $ReferenceNo = $candidate->ReferenceNo;
        $Email = $candidate->Email;
        $Phone = $candidate->Phone;

        $Employee = getFullName(Auth::user()->id);
        $Recruiter_Name = getFullName($jobpost->CreatedBy);

        if ($query) {

            $detals = [
                'subject' => 'Shortlisting Notification: ' . $Name . ' for Interview',
                'Name' => $Name,
                'ReferenceNo' => $ReferenceNo,
                'Email' => $Email,
                'Phone' => $Phone,
                'Employee' => $Employee,
                'Recruiter_Name' => $Recruiter_Name,
                'Job_Code' => $job_code
            ];

            Mail::to(getEmailID($jobpost->CreatedBy))->send(new SLDPTMail($detals));
            UserNotification::notifyUser($jobpost->CreatedBy, 'Shortlisting Notification', $job_code);
            return response()->json(['status' => 200, 'msg' => 'Candidate Shortlisted Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    public function sldpt_process_from_databank(Request $request)
    {
        $JAId = $request->JAId;

        $query = jobapply::find($JAId);

        $JCId = $query->JCId;

        $query->SLDPT = 'Y';
        $query->SLDPT_By = Auth::user()->id;
        $query->SLDPT_Date = now();
        $query->save();


        $candidate = jobcandidate::find($JCId);
        $Name = implode(' ', [$candidate->FName, $candidate->LName]);
        $ReferenceNo = $candidate->ReferenceNo;
        $Email = $candidate->Email;
        $Phone = $candidate->Phone;

        $Employee = getFullName(Auth::user()->id);


        if ($query) {

            $detals = [
                'subject' => 'Shortlisting Notification: ' . $Name . ' for Interview',
                'Name' => $Name,
                'ReferenceNo' => $ReferenceNo,
                'Email' => $Email,
                'Phone' => $Phone,
                'Employee' => $Employee,
                'Recruiter_Name' => 'Recruiter',
                'Job_Code' => getDepartmentCode($query->Department).' Department'
            ];

            Mail::to('am2.hr@vnrseeds.com')->cc('debrat.roy@vnrseeds.com')->send(new SLDPTMail($detals));

            return response()->json(['status' => 200, 'msg' => 'Candidate Shortlisted Successfully']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }

    function getMRFTAT(Request $request)
    {

        $MRFId = $request->MRFId;
        // Fetch the start date from the 'manpowerrequisition' table where 'MRFId' is  $MRFId
        $startDate = Carbon::parse(DB::table('manpowerrequisition')->where('MRFId', $MRFId)->value('CreatedTime'));

        // Get the current date
        $endDate = Carbon::now();

        // Define the day of the week from which you want to group the weeks (1 for Monday)
        $startOfWeek = 1;

        // Initialize an array to store the grouped weeks
        $weeks = [];

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $weekStart = $currentDate->copy()->startOfWeek($startOfWeek);

            // Exclude Sunday from the end of the week
            $weekEnd = $currentDate->copy()->startOfWeek($startOfWeek)->next(Carbon::SUNDAY);
            //$weekEnd = $currentDate->copy()->endOfWeek($startOfWeek);


            // Store the week in your desired format
            $week = [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
            ];

            $weeks[] = $week;

            // Move to the next week
            $currentDate->startOfWeek()->next(Carbon::SUNDAY)->addDay();


        }

        $cv_receive = [];
        $resume_screening = [];
        $hr_screening = [];
        $tech_screening = [];
        $interview_arr = [];
        $second_interview = [];
        $job_offer = [];
        $offer_accepted = [];
        $joined = [];

        // Display the grouped weeks
        foreach ($weeks as $week) {

            $applyCounts = DB::table('jobapply')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(ApplyDate)'), [$week['start'], $week['end']])
                ->count();

            $cv_receive[] = [
                "label" => $week['start'] . ' - ' . $week['end'],
                "y" => $applyCounts
            ];

            $resumeScreening = DB::table('jobcandidates')
                ->leftJoin('jobapply', 'jobapply.JCId', '=', 'jobcandidates.JCId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(Suitable_Chk_Date)'), [$week['start'], $week['end']])
                ->count();

            $resume_screening[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $resumeScreening
            ];

            $hrScreening = DB::table('jobapply')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(HrScreeningDate)'), [$week['start'], $week['end']])
                ->count();

            $hr_screening[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $hrScreening
            ];

            $techScreening = DB::table('screening')
                ->leftJoin('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(ResScreened)'), [$week['start'], $week['end']])
                ->count();

            $tech_screening[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $techScreening
            ];

            $interview = DB::table('screening')->leftJoin('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(IntervDt)'), [$week['start'], $week['end']])
                ->count();

            $interview_arr[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $interview
            ];

            $interview2nd = DB::table('screen2ndround')
                ->leftJoin('screening', 'screening.ScId', '=', 'screen2ndround.ScId')
                ->leftJoin('jobapply', 'jobapply.JAId', '=', 'screening.JAId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(IntervDt2)'), [$week['start'], $week['end']])
                ->count();

            $second_interview[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $interview2nd
            ];

            $offer = DB::table('candjoining')->leftJoin('jobapply', 'jobapply.JAId', '=', 'candjoining.JAId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(LinkValidityStart)'), [$week['start'], $week['end']])
                ->count();

            $job_offer[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $offer
            ];

            $accept = DB::table('candjoining')->leftJoin('jobapply', 'jobapply.JAId', '=', 'candjoining.JAId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(Date)'), [$week['start'], $week['end']])
                ->count();

            $offer_accepted[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $accept
            ];

            $join = DB::table('candjoining')->leftJoin('jobapply', 'jobapply.JAId', '=', 'candjoining.JAId')
                ->leftJoin('jobpost', 'jobpost.JPId', '=', 'jobapply.JPId')
                ->where('jobpost.MRFId', $MRFId)
                ->whereBetween(DB::raw('DATE(JoinOnDt)'), [$week['start'], $week['end']])
                ->count();

            $joined[] = [
                "label" => date('d-m-Y', strtotime($week['start'])) . ' - ' . date('d-m-Y', strtotime($week['end'])),
                "y" => $join
            ];

        }

        $job_code = DB::table('jobpost')->where('MRFId', $MRFId)->value('JobCode');

        $final = [
            "job_code" => $job_code,
            "cv_receive" => $cv_receive,
            "resume_screening" => $resume_screening,
            "tech_screening" => $tech_screening,
            "interview" => $interview_arr,
            "second_interview" => $second_interview,
            "hr_screening" => $hr_screening,
            "job_offer" => $job_offer,
            "offer_accepted" => $offer_accepted,
            "joined" => $joined
        ];

        return $final;

    }

    public function download_candidate_data_mrf_wise(int $mrfid)
    {
        try {
            $job_code = jobpost::where('MRFId', $mrfid)->value('JobCode');
            return Excel::download(new HodMrfWiseData(), $job_code . '.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong' . $e->getMessage()]);
        }
    }

    public function checkDuplicate(Request $request)
    {
        $count = DB::table('jobcandidates')
            ->where('Phone', '=', $request->Phone)
            ->orWhere('Email', '=', $request->Email)
            ->count();
        return response()->json(['count' => $count]);
    }

}
