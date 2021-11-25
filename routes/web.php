<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\HeadquarterController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\EduSpecialController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Admin\ResumeSourcController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommunicationController;

use App\Http\Controllers\Recruiter\RecruiterController;
use App\Http\Controllers\Recruiter\MrfAllocatedController;

use App\Http\Controllers\Hod\HodController;
use App\Http\Controllers\Hod\MrfController;
use App\Http\Controllers\Hod\MyTeamController;


use App\Http\Controllers\Common\CampusController;
use App\Http\Controllers\Common\ManualEntryController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\JobApplicationController;
use App\Http\Controllers\Common\OfferLtrController;
use App\Http\Controllers\Common\TrackerController;
use App\Http\Controllers\JobController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['middleware' => 'PreventBackHistory'])->group(function () {
    Auth::routes();
});


Route::group(['prefix' => 'jobportal'], function () {
    Route::get('jobs', [JobController::class, 'jobs'])->name('jobs');
    Route::get('job_apply_form', [JobController::class, 'job_apply_form'])->name('job_apply_form');
    Route::get('jobapply', [JobController::class, 'job_apply_form_manual']);
    Route::post('job_apply', [JobController::class, 'job_apply'])->name('job_apply');
    Route::post('job_apply_manual', [JobController::class, 'job_apply_manual'])->name('job_apply_manual');
    Route::get('campus_apply_form', [JobController::class, 'campus_apply_form'])->name('campus_apply_form');
    Route::post('campus_apply', [JobController::class, 'campus_apply'])->name('campus_apply');
    Route::get('verification', [JobController::class, 'verification'])->name('verification');
    Route::post('otpverify', [JobController::class, 'otpverify'])->name('otpverify');
    Route::get('confirmation', [JobController::class, 'confirmation'])->name('confirmation');
    Route::get('campus_placement_registration', [JobController::class, 'campus_placement_registration'])->name('campus_placement_registration');
});

Route::post('setTheme', [CommonController::class, 'setTheme'])->name('setTheme');
Route::get('getDepartment', [CommonController::class, 'getDepartment'])->name('getDepartment');
Route::get('getDesignation', [CommonController::class, 'getDesignation'])->name('getDesignation');
Route::get('getReportingManager', [CommonController::class, 'getReportingManager'])->name('getReportingManager');
Route::get('getResignedEmployee', [CommonController::class, 'getResignedEmployee'])->name('getResignedEmployee');
Route::get('getResignedEmpDetail', [CommonController::class, 'getResignedEmpDetail'])->name('getResignedEmpDetail');
Route::get('getState', [CommonController::class, 'getState'])->name('getState');
Route::get('getDistrict', [CommonController::class, 'getDistrict'])->name('getDistrict');
Route::get('getHq', [CommonController::class, 'getHq'])->name('getHq');
Route::get('getEducation', [CommonController::class, 'getEducation'])->name('getEducation');
Route::get('getSpecialization', [CommonController::class, 'getSpecialization'])->name('getSpecialization');
Route::get('getAllDistrict', [CommonController::class, 'getAllDistrict'])->name('getAllDistrict');
Route::get('getAllSP', [CommonController::class, 'getAllSP'])->name('getAllSP');
Route::post('getMRFDetails', [CommonController::class, 'getMRFDetails'])->name('getMRFDetails');
Route::post('updateMRF', [CommonController::class, 'updateMRF'])->name('updateMRF');
Route::post('deleteMRF', [CommonController::class, 'deleteMRF'])->name('deleteMRF');
Route::post('notificationMarkRead', [CommonController::class, 'notificationMarkRead'])->name('notificationMarkRead');
Route::post('markAllRead', [CommonController::class, 'markAllRead'])->name('markAllRead');
Route::get('getMRFByDepartment', [CommonController::class, 'getMRFByDepartment'])->name('getMRFByDepartment');





Route::get('job_response', [JobApplicationController::class, 'job_response'])->name('job_response');
Route::get('job_applications', [JobApplicationController::class, 'job_applications'])->name('job_applications');
Route::post('getJobResponseSummary', [JobApplicationController::class, 'getJobResponseSummary'])->name('getJobResponseSummary');
Route::post('getCandidates', [JobApplicationController::class, 'getCandidates'])->name('getCandidates');
Route::post('update_hrscreening', [JobApplicationController::class, 'update_hrscreening'])->name('update_hrscreening');
Route::post('SendForTechScreening', [JobApplicationController::class, 'SendForTechScreening'])->name('SendForTechScreening');
Route::post('MapCandidateToJob', [JobApplicationController::class, 'MapCandidateToJob'])->name('MapCandidateToJob');
Route::post('MoveCandidate', [JobApplicationController::class, 'MoveCandidate'])->name('MoveCandidate');
Route::post('BlacklistCandidate', [JobApplicationController::class, 'BlacklistCandidate'])->name('BlacklistCandidate');
Route::post('UnBlockCandidate', [JobApplicationController::class, 'UnBlockCandidate'])->name('UnBlockCandidate');
Route::get('job_application_manual_entry_form', [JobApplicationController::class, 'job_application_manual_entry_form'])->name('job_application_manual_entry_form');
Route::post('job_application_manual', [JobApplicationController::class, 'job_application_manual'])->name('job_application_manual');
Route::get('getManualEntryCandidate', [JobApplicationController::class, 'getManualEntryCandidate'])->name('getManualEntryCandidate');
Route::post('getJobResponseCandidateByJPId', [JobApplicationController::class, 'getJobResponseCandidateByJPId'])->name('getJobResponseCandidateByJPId');
Route::post('cropImage', [JobApplicationController::class, 'cropImage'])->name('cropImage');


Route::get('TechnicalScreening', [TrackerController::class, 'TechnicalScreening'])->name('TechnicalScreening');
Route::post('getTechnicalSceeningCandidate', [TrackerController::class, 'getTechnicalSceeningCandidate'])->name('getTechnicalSceeningCandidate');
Route::post('getScreenDetail', [TrackerController::class, 'getScreenDetail'])->name('getScreenDetail');
Route::post('CandidateTechnicalScreening', [TrackerController::class, 'CandidateTechnicalScreening'])->name('CandidateTechnicalScreening');
Route::post('getInterviewTrackerCandidate', [TrackerController::class, 'getInterviewTrackerCandidate'])->name('getInterviewTrackerCandidate');
Route::get('interview_tracker', [TrackerController::class, 'interview_tracker'])->name('interview_tracker');
Route::post('first_round_interview', [TrackerController::class, 'first_round_interview'])->name('first_round_interview');
Route::post('second_round_interview', [TrackerController::class, 'second_round_interview'])->name('second_round_interview');
Route::post('select_cmp_dpt_for_candidate', [TrackerController::class, 'select_cmp_dpt_for_candidate'])->name('select_cmp_dpt_for_candidate');


Route::get('offer_letter', [OfferLtrController::class, 'offer_letter'])->name('offer_letter');
Route::post('update_offerletter_basic', [OfferLtrController::class, 'update_offerletter_basic'])->name('update_offerletter_basic');
Route::get('get_offerltr_basic_detail', [OfferLtrController::class, 'get_offerltr_basic_detail'])->name('get_offerltr_basic_detail');
Route::get('offer_letter_generate', [OfferLtrController::class, 'offer_letter_generate'])->name('offer_letter_generate');


Route::get('recruiter_mrf_entry', [ManualEntryController::class, 'recruiter_mrf_entry'])->name('recruiter_mrf_entry');
Route::get('get_all_manual_mrf_created_by_me', [ManualEntryController::class, 'get_all_manual_mrf_created_by_me'])->name('get_all_manual_mrf_created_by_me');
Route::get('mrf', [ManualEntryController::class, 'mrf'])->name('mrf');
Route::get('new_mrf_manual', [ManualEntryController::class, 'new_mrf_manual'])->name('new_mrf_manual');
Route::get('replacement_mrf_manual', [ManualEntryController::class, 'replacement_mrf_manual'])->name('replacement_mrf_manual');
Route::get('sip_mrf_manual', [ManualEntryController::class, 'sip_mrf_manual'])->name('sip_mrf_manual');
Route::get('campus_mrf_manual', [ManualEntryController::class, 'campus_mrf_manual'])->name('campus_mrf_manual');
Route::post('add_new_mrf_manual', [ManualEntryController::class, 'add_new_mrf_manual'])->name('add_new_mrf_manual');
Route::post('add_sip_mrf_manual', [ManualEntryController::class, 'add_sip_mrf_manual'])->name('add_sip_mrf_manual');
Route::post('add_campus_mrf_manual', [ManualEntryController::class, 'add_campus_mrf_manual'])->name('add_campus_mrf_manual');
Route::post('add_replacement_mrf_manual', [ManualEntryController::class, 'add_replacement_mrf_manual'])->name('add_replacement_mrf_manual');

Route::post('createJobPost_Campus', [CampusController::class, 'createJobPost_Campus'])->name('createJobPost_Campus');
Route::post('getAllCampusAllocatedMrf', [CampusController::class, 'getAllCampusAllocatedMrf'])->name('getAllCampusAllocatedMrf');
Route::get('campus_mrf_allocated', [CampusController::class, 'campus_mrf_allocated'])->name('campus_mrf_allocated');
Route::get('campus_applications', [CampusController::class, 'campus_applications'])->name('campus_applications');
Route::get('campus_screening_tracker', [CampusController::class, 'campus_screening_tracker'])->name('campus_screening_tracker');
Route::get('campus_hiring_tracker', [CampusController::class, 'campus_hiring_tracker'])->name('campus_hiring_tracker');
Route::post('getCampusSummary', [CampusController::class, 'getCampusSummary'])->name('getCampusSummary');
Route::post('getCampusHiringCandidates', [CampusController::class, 'getCampusHiringCandidates'])->name('getCampusHiringCandidates');
Route::post('getCampusScreeningCandidates', [CampusController::class, 'getCampusScreeningCandidates'])->name('getCampusScreeningCandidates');
Route::post('getPostTitle', [CampusController::class, 'getPostTitle'])->name('getPostTitle');
Route::post('getCandidateName', [CampusController::class, 'getCandidateName'])->name('getCandidateName');
Route::post('ChngGDResult', [CampusController::class, 'ChngGDResult'])->name('ChngGDResult');
Route::post('ChngScreenStatus', [CampusController::class, 'ChngScreenStatus'])->name('ChngScreenStatus');
Route::post('getCampusCandidates', [CampusController::class, 'getCampusCandidates'])->name('getCampusCandidates');
Route::post('SavePlacementDate', [CampusController::class, 'SavePlacementDate'])->name('SavePlacementDate');
Route::post('SaveTestScore', [CampusController::class, 'SaveTestScore'])->name('SaveTestScore');
Route::post('SendForScreening', [CampusController::class, 'SendForScreening'])->name('SendForScreening');
Route::post('SaveFirstInterview_Campus', [CampusController::class, 'SaveFirstInterview_Campus'])->name('SaveFirstInterview_Campus');
Route::post('SaveSecondInterview_Campus', [CampusController::class, 'SaveSecondInterview_Campus'])->name('SaveSecondInterview_Campus');
Route::post('Save_Cmp_Dpt_Campus', [CampusController::class, 'Save_Cmp_Dpt_Campus'])->name('Save_Cmp_Dpt_Campus');

Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('mrf', [AdminController::class, 'mrf'])->name('admin.mrf');
    Route::get('active_mrf', [AdminController::class, 'active_mrf'])->name('admin.active_mrf');
    Route::get('closedmrf', [AdminController::class, 'closedmrf'])->name('admin.closedmrf');
    Route::post('getNewMrf', [AdminController::class, 'getNewMrf'])->name('getNewMrf');
    Route::post('getActiveMrf', [AdminController::class, 'getActiveMrf'])->name('getActiveMrf');
    Route::post('getCloseMrf', [AdminController::class, 'getCloseMrf'])->name('getCloseMrf');
    Route::post('updateMRFStatus', [AdminController::class, 'updateMRFStatus'])->name('updateMRFStatus');
    Route::post('allocateMRF', [AdminController::class, 'allocateMRF'])->name('allocateMRF');
    Route::post('getTaskList', [AdminController::class, 'getTaskList'])->name('getTaskList');
    Route::post('getRecruiterName', [AdminController::class, 'getRecruiterName'])->name('getRecruiterName');
    Route::get('setting', [AdminController::class, 'setting'])->name('admin.setting');


    // ! ======================Master Company ========================//
    Route::get('company', [CompanyController::class, 'company'])->name('admin.company');
    Route::post('addCompany', [CompanyController::class, 'addCompany'])->name('addCompany');
    Route::get('getAllCompanyData', [CompanyController::class, 'getAllCompanyData'])->name('getAllCompanyData');
    Route::post('getCompanyDetails', [CompanyController::class, 'getCompanyDetails'])->name('getCompanyDetails');
    Route::post('editCompany', [CompanyController::class, 'editCompany'])->name('editCompany');
    Route::post('deleteCompany', [CompanyController::class, 'deleteCompany'])->name('deleteCompany');
    Route::post('syncCompany', [CompanyController::class, 'syncCompany'])->name('syncCompany');
    // ! =====================================================================//

    // ?==========================Master Country ==============================// 
    Route::get('country', [CountryController::class, 'country'])->name('admin.country');
    Route::post('addCountry', [CountryController::class, 'addCountry'])->name('addCountry');
    Route::get('getAllCountryData', [CountryController::class, 'getAllCountryData'])->name('getAllCountryData');
    Route::post('getCountryDetails', [CountryController::class, 'getCountryDetails'])->name('getCountryDetails');
    Route::post('editCountry', [CountryController::class, 'editCountry'])->name('editCountry');
    Route::post('deleteCountry', [CountryController::class, 'deleteCountry'])->name('deleteCountry');
    Route::post('syncCountry', [CountryController::class, 'syncCountry'])->name('syncCountry');
    // ?=========================================================================================//

    // ?==========================Master State ==============================// 
    Route::get('state', [StateController::class, 'state'])->name('admin.state');
    Route::post('addState', [StateController::class, 'addState'])->name('addState');
    Route::get('getAllStateData', [StateController::class, 'getAllStateData'])->name('getAllStateData');
    Route::post('getStateDetails', [StateController::class, 'getStateDetails'])->name('getStateDetails');
    Route::post('editState', [StateController::class, 'editState'])->name('editState');
    Route::post('deleteState', [StateController::class, 'deleteState'])->name('deleteState');
    Route::post('syncState', [StateController::class, 'syncState'])->name('syncState');
    // ?=========================================================================================//

    //*====================================Master Employee ==================================//
    Route::get('employee', [EmployeeController::class, 'employee'])->name('admin.employee');
    Route::get('getAllEmployeeData', [EmployeeController::class, 'getAllEmployeeData'])->name('getAllEmployeeData');
    Route::post('syncEmployee', [EmployeeController::class, 'syncEmployee'])->name('syncEmployee');
    //*======================================================================================//

    //*====================================Master Headquarter ==================================//
    Route::get('headquarter', [HeadquarterController::class, 'headquarter'])->name('admin.headquarter');
    Route::get('getAllHeadquarter', [HeadquarterController::class, 'getAllHeadquarter'])->name('getAllHeadquarter');
    Route::post('syncHeadquarter', [HeadquarterController::class, 'syncHeadquarter'])->name('syncHeadquarter');
    //*==========================================================================================//

    //*====================================Master Department ==================================//
    Route::get('department', [DepartmentController::class, 'department'])->name('admin.department');
    Route::get('getAllDepartment', [DepartmentController::class, 'getAllDepartment'])->name('getAllDepartment');
    Route::post('syncDepartment', [DepartmentController::class, 'syncDepartment'])->name('syncDepartment');
    //*========================================================================================//

    //*====================================Master Designation ==================================//
    Route::get('designation', [DesignationController::class, 'designation'])->name('admin.designation');
    Route::get('getAllDesignation', [DesignationController::class, 'getAllDesignation'])->name('getAllDesignation');
    Route::post('syncDesignation', [DesignationController::class, 'syncDesignation'])->name('syncDesignation');
    //*=================================================================================================//

    //*====================================Master Designation ==================================//
    Route::get('grade', [GradeController::class, 'grade'])->name('admin.grade');
    Route::get('getAllGrade', [GradeController::class, 'getAllGrade'])->name('getAllGrade');
    Route::post('syncGrade', [GradeController::class, 'syncGrade'])->name('syncGrade');
    //*=================================================================================================//

    // ?==========================Master District ==============================// 
    Route::get('district', [DistrictController::class, 'district'])->name('admin.district');
    Route::post('addDistrict', [DistrictController::class, 'addDistrict'])->name('addDistrict');
    Route::get('getDistrictList', [DistrictController::class, 'getDistrictList'])->name('getDistrictList');
    Route::post('getDistrictDetails', [DistrictController::class, 'getDistrictDetails'])->name('getDistrictDetails');
    Route::post('editDistrict', [DistrictController::class, 'editDistrict'])->name('editDistrict');
    Route::post('deleteDistrict', [DistrictController::class, 'deleteDistrict'])->name('deleteDistrict');
    // ?=========================================================================================//

    // ?==========================Master Education ==============================// 
    Route::get('education', [EducationController::class, 'education'])->name('admin.education');
    Route::post('addEducation', [EducationController::class, 'addEducation'])->name('addEducation');
    Route::get('getAllEducation', [EducationController::class, 'getAllEducation'])->name('getAllEducation');
    Route::post('getEducationDetails', [EducationController::class, 'getEducationDetails'])->name('getEducationDetails');
    Route::post('editEducation', [EducationController::class, 'editEducation'])->name('editEducation');
    Route::post('deleteEducation', [EducationController::class, 'deleteEducation'])->name('deleteEducation');
    // ?=========================================================================================//

    //** ======================= Education Specialization ===================== */
    Route::get('eduspecialization', [EduSpecialController::class, 'eduspecialization'])->name('admin.eduspecialization');
    Route::post('addEduSpe', [EduSpecialController::class, 'addEduSpe'])->name('addEduSpe');
    Route::get('getAllEduSpe', [EduSpecialController::class, 'getAllEduSpe'])->name('getAllEduSpe');
    Route::post('getEduSpeDetails', [EduSpecialController::class, 'getEduSpeDetails'])->name('getEduSpeDetails');
    Route::post('editEduSpe', [EduSpecialController::class, 'editEduSpe'])->name('editEduSpe');
    Route::post('deleteEduSpe', [EduSpecialController::class, 'deleteEduSpe'])->name('deleteEduSpe');
    //**====================================================================== */

    //? ======================= Education Specialization ===================== */
    Route::get('institute', [InstituteController::class, 'institute'])->name('admin.institute');
    Route::post('addInstitute', [InstituteController::class, 'addInstitute'])->name('addInstitute');
    Route::get('getAllInstitute', [InstituteController::class, 'getAllInstitute'])->name('getAllInstitute');
    Route::post('getInstituteDetails', [InstituteController::class, 'getInstituteDetails'])->name('getInstituteDetails');
    Route::post('editInstitute', [InstituteController::class, 'editInstitute'])->name('editInstitute');
    Route::post('deleteInstitute', [InstituteController::class, 'deleteInstitute'])->name('deleteInstitute');

    //?====================================================================== */

    //**=============================Resume Source================================================= */
    Route::get('resumesource', [ResumeSourcController::class, 'resumesource'])->name('admin.resumesource');
    Route::post('addResumeSource', [ResumeSourcController::class, 'addResumeSource'])->name('addResumeSource');
    Route::get('getAllResumeSource', [ResumeSourcController::class, 'getAllResumeSource'])->name('getAllResumeSource');
    Route::post('getResumeSourceDetails', [ResumeSourcController::class, 'getResumeSourceDetails'])->name('getResumeSourceDetails');
    Route::post('editResumeSource', [ResumeSourcController::class, 'editResumeSource'])->name('editResumeSource');
    Route::post('deleteResumeSource', [ResumeSourcController::class, 'deleteResumeSource'])->name('deleteResumeSource');
    //**=========================================================================================== */

    //? ======================= User Master ===================== */
    Route::get('userlist', [UserController::class, 'userlist'])->name('admin.userlist');
    Route::post('addUser', [UserController::class, 'addUser'])->name('addUser');
    Route::get('getAllUser', [UserController::class, 'getAllUser'])->name('getAllUser');
    Route::post('cngUserPwd', [UserController::class, 'cngUserPwd'])->name('cngUserPwd');
    Route::post('deleteUser', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::get('getEmployee', [UserController::class, 'getEmployee'])->name('getEmployee');
    Route::get('getEmployeeDetail', [UserController::class, 'getEmployeeDetail'])->name('getEmployeeDetail');

    //?====================================================================== */
    Route::get('communication_control', [CommunicationController::class, 'communication_control'])->name('admin.communication_control');
    Route::get('getCommunicationTopic', [CommunicationController::class, 'getCommunicationTopic'])->name('getCommunicationTopic');
    Route::post('setCommunication', [CommunicationController::class, 'setCommunication'])->name('setCommunication');
});


Route::group(['prefix' => 'recruiter', 'middleware' => ['isRecruiter', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [RecruiterController::class, 'index'])->name('recruiter.dashboard');
    Route::get('mrf_allocated', [MrfAllocatedController::class, 'mrf_allocated'])->name('mrf_allocated');
    Route::post('getAllAllocatedMRF', [MrfAllocatedController::class, 'getAllAllocatedMRF'])->name('getAllAllocatedMRF');
    Route::post('getDetailForJobPost', [MrfAllocatedController::class, 'getDetailForJobPost'])->name('getDetailForJobPost');
    Route::post('createJobPost', [MrfAllocatedController::class, 'createJobPost'])->name('createJobPost');
    Route::post('ChngPostingView', [MrfAllocatedController::class, 'ChngPostingView'])->name('ChngPostingView');
});

Route::group(['prefix' => 'hod', 'middleware' => ['isHod', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [HodController::class, 'index'])->name('hod.dashboard');

    Route::get('mrfbyme', [HodController::class, 'mrfbyme'])->name('mrfbyme');
    //**========================My Team =========================================== */
    Route::get('myteam', [MyTeamController::class, 'myteam'])->name('myteam');
    Route::get('getAllMyTeamMember', [MyTeamController::class, 'getAllMyTeamMember'])->name('getAllMyTeamMember');
    Route::post('getMyTeam', [MyTeamController::class, 'getMyTeam'])->name('getMyTeam');
    Route::get('repmrf', [MyTeamController::class, 'repmrf'])->name('repmrf');
    //!=============================MRF===============================================//
    Route::get('mrf', [MrfController::class, 'mrf'])->name('mrf');
    Route::get('new_mrf', [MrfController::class, 'new_mrf'])->name('new_mrf');
    Route::get('sip_mrf', [MrfController::class, 'sip_mrf'])->name('sip_mrf');
    Route::get('campus_mrf', [MrfController::class, 'campus_mrf'])->name('campus_mrf');
    Route::post('addNewMrf', [MrfController::class, 'addNewMrf'])->name('addNewMrf');
    Route::post('addSipMrf', [MrfController::class, 'addSipMrf'])->name('addSipMrf');
    Route::post('addCampusMrf', [MrfController::class, 'addCampusMrf'])->name('addCampusMrf');
    Route::post('addRepMrf', [MrfController::class, 'addRepMrf'])->name('addRepMrf');
    Route::get('getAllMRFCreatedByMe', [MrfController::class, 'getAllMRFCreatedByMe'])->name('getAllMRFCreatedByMe');
    //!==============================================================================//
});
