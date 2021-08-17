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


use App\Http\Controllers\Recruiter\RecruiterController;


use App\Http\Controllers\Hod\HodController;
use App\Http\Controllers\Hod\MrfController;
use App\Http\Controllers\Hod\MyTeamController;
use App\Http\Controllers\TestMail;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['middleware' => 'PreventBackHistory'])->group(function () {
    Auth::routes();
});


Route::get('TestMail',[TestMail::class,'sendMail'] )->name('TestMail');
Route::get('TestMail1',[TestMail::class,'sendMail1'] )->name('TestMail1');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('mrf', [AdminController::class, 'mrf'])->name('admin.mrf');
    Route::get('getAllMRF', [AdminController::class, 'getAllMRF'])->name('getAllMRF');
    Route::post('updateMRFStatus',[AdminController::class,'updateMRFStatus'])->name('updateMRFStatus');
    Route::post('allocateMRF',[AdminController::class,'allocateMRF'])->name('allocateMRF');
    Route::get('getDepartmentMRFAdmin', [AdminController::class,'getDepartmentMRFAdmin'])->name('getDepartmentMRFAdmin');
    Route::get('getDesignationMRFAdmin', [AdminController::class,'getDesignationMRFAdmin'])->name('getDesignationMRFAdmin');
    Route::get('getRepMgrMRFAdmin', [AdminController::class,'getRepMgrMRFAdmin'])->name('getRepMgrMRFAdmin');
    Route::post('getMRFDetails', [AdminController::class,'getMRFDetails'])->name('getMRFDetails');
    Route::post('editMRFAdmin', [AdminController::class, 'editMRFAdmin'])->name('editMRFAdmin');
    Route::post('getTaskList', [AdminController::class, 'getTaskList'])->name('getTaskList');
    Route::post('getRecruiterName', [AdminController::class, 'getRecruiterName'])->name('getRecruiterName');
    Route::get('getStateAdmin', [AdminController::class,'getStateAdmin'])->name('getStateAdmin');
    Route::get('getCityAdmin', [AdminController::class,'getCityAdmin'])->name('getCityAdmin');
    Route::get('getEducationAdmin', [AdminController::class,'getEducationAdmin'])->name('getEducationAdmin');

    Route::get('setting', [AdminController::class, 'setting'])->name('admin.setting');

    Route::post('setTheme', [AdminController::class, 'setTheme'])->name('admin.setTheme');

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
    Route::get('getAllDistrict', [DistrictController::class, 'getAllDistrict'])->name('getAllDistrict');
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
    Route::get('getDistrict', [InstituteController::class, 'getDistrict'])->name('getDistrict');
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
    Route::get('getEmployee',[UserController::class, 'getEmployee'])->name('getEmployee');
    Route::get('getEmployeeDetail',[UserController::class, 'getEmployeeDetail'])->name('getEmployeeDetail');
    
    //?====================================================================== */


});


Route::group(['prefix' => 'recruiter', 'middleware' => ['isRecruiter', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [RecruiterController::class, 'index'])->name('recruiter.dashboard');
    Route::post('setTheme', [RecruiterController::class, 'setTheme'])->name('setTheme');
});

Route::group(['prefix' => 'hod', 'middleware' => ['isHod', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [HodController::class, 'index'])->name('hod.dashboard');
    Route::post('setTheme', [HodController::class, 'setTheme'])->name('setTheme');
    Route::get('mrfbyme', [HodController::class,'mrfbyme'])->name('mrfbyme');

    //**========================My Team =========================================== */
    Route::get('myteam',[MyTeamController::class,'myteam'])->name('myteam');
    Route::get('getAllMyTeamMember', [MyTeamController::class, 'getAllMyTeamMember'])->name('getAllMyTeamMember');
    Route::post('getMyTeam', [MyTeamController::class, 'getMyTeam'])->name('getMyTeam');
    Route::get('repmrf', [MyTeamController::class,'repmrf'])->name('repmrf');
        
    //**=========================================================================== */

    //!=============================MRF===============================================//
    Route::get('newmrf',[MrfController::class,'newmrf'])->name('newmrf');
    Route::post('addNewMrf', [MrfController::class, 'addNewMrf'])->name('addNewMrf');
    Route::post('addRepMrf', [MrfController::class, 'addRepMrf'])->name('addRepMrf');

    Route::get('getDepartment', [MrfController::class,'getDepartment'])->name('getDepartment');
    Route::get('getDesignation', [MrfController::class,'getDesignation'])->name('getDesignation');
    Route::get('getReportingManager', [MrfController::class,'getReportingManager'])->name('getReportingManager');
    Route::get('getState', [MrfController::class,'getState'])->name('getState');
    Route::get('getDistrict', [MrfController::class,'getDistrict'])->name('getDistrict');
    Route::get('getEducation', [MrfController::class,'getEducation'])->name('getEducation');
    Route::get('getSpecialization', [MrfController::class,'getSpecialization'])->name('getSpecialization');
    Route::get('getAllMRFCreatedByMe', [MrfController::class,'getAllMRFCreatedByMe'])->name('getAllMRFCreatedByMe');
    //!==============================================================================//
 
   
});




