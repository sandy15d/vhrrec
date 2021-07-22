<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HeadquarterController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EduSpecialController;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

Route::get('/', function () {
    //return Activity::all();
    return view('auth.login');
});

Route::middleware(['middleware' => 'PreventBackHistory'])->group(function () {
    Auth::routes();
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('settings', [AdminController::class, 'settings'])->name('admin.settings');

    // ! ======================Master Company ========================//
    Route::get('company', [CompanyController::class, 'company'])->name('admin.company');
    Route::post('addCompany',[CompanyController::class,'addCompany'])->name('addCompany');
    Route::get('getAllCompanyData',[CompanyController::class,'getAllCompanyData'])->name('getAllCompanyData');
    Route::post('getCompanyDetails',[CompanyController::class,'getCompanyDetails'])->name('getCompanyDetails');
    Route::post('editCompany',[CompanyController::class,'editCompany'])->name('editCompany');
    Route::post('deleteCompany',[CompanyController::class,'deleteCompany'])->name('deleteCompany');
    Route::post('syncCompany',[CompanyController::class,'syncCompany'])->name('syncCompany');
   // ! =====================================================================//

   // ?==========================Master Country ==============================// 
   Route::get('country', [CountryController::class, 'country'])->name('admin.country');
   Route::post('addCountry',[CountryController::class,'addCountry'])->name('addCountry');
   Route::get('getAllCountryData',[CountryController::class,'getAllCountryData'])->name('getAllCountryData');
   Route::post('getCountryDetails',[CountryController::class,'getCountryDetails'])->name('getCountryDetails');
   Route::post('editCountry',[CountryController::class,'editCountry'])->name('editCountry');
   Route::post('deleteCountry',[CountryController::class,'deleteCountry'])->name('deleteCountry');
   Route::post('syncCountry',[CountryController::class,'syncCountry'])->name('syncCountry');
 // ?=========================================================================================//

    // ?==========================Master State ==============================// 
    Route::get('state', [StateController::class, 'state'])->name('admin.state');
    Route::post('addState',[StateController::class,'addState'])->name('addState');
    Route::get('getAllStateData',[StateController::class,'getAllStateData'])->name('getAllStateData');
    Route::post('getStateDetails',[StateController::class,'getStateDetails'])->name('getStateDetails');
    Route::post('editState',[StateController::class,'editState'])->name('editState');
    Route::post('deleteState',[StateController::class,'deleteState'])->name('deleteState');
    Route::post('syncState',[StateController::class,'syncState'])->name('syncState');
    // ?=========================================================================================//
 
    //*====================================Master Employee ==================================//
    Route::get('employee', [EmployeeController::class, 'employee'])->name('admin.employee');
    Route::get('getAllEmployeeData', [EmployeeController::class, 'getAllEmployeeData'])->name('getAllEmployeeData');
    Route::post('syncEmployee',[EmployeeController::class,'syncEmployee'])->name('syncEmployee');
    //*======================================================================================//

    //*====================================Master Headquarter ==================================//
    Route::get('headquarter', [HeadquarterController::class, 'headquarter'])->name('admin.headquarter');
    Route::get('getAllHeadquarter', [HeadquarterController::class, 'getAllHeadquarter'])->name('getAllHeadquarter');
    Route::post('syncHeadquarter',[HeadquarterController::class,'syncHeadquarter'])->name('syncHeadquarter');
    //*==========================================================================================//

    //*====================================Master Department ==================================//
    Route::get('department', [DepartmentController::class, 'department'])->name('admin.department');
    Route::get('getAllDepartment', [DepartmentController::class, 'getAllDepartment'])->name('getAllDepartment');
    Route::post('syncDepartment',[DepartmentController::class,'syncDepartment'])->name('syncDepartment');
    //*========================================================================================//

    //*====================================Master Designation ==================================//
    Route::get('designation', [DesignationController::class, 'designation'])->name('admin.designation');
    Route::get('getAllDesignation', [DesignationController::class, 'getAllDesignation'])->name('getAllDesignation');
    Route::post('syncDesignation',[DesignationController::class,'syncDesignation'])->name('syncDesignation');
    //*=================================================================================================//

    //*====================================Master Designation ==================================//
    Route::get('grade', [GradeController::class, 'grade'])->name('admin.grade');
    Route::get('getAllGrade', [GradeController::class, 'getAllGrade'])->name('getAllGrade');
    Route::post('syncGrade',[GradeController::class,'syncGrade'])->name('syncGrade');
    //*=================================================================================================//

   // ?==========================Master District ==============================// 
   Route::get('district', [DistrictController::class, 'district'])->name('admin.district');
   Route::post('addDistrict',[DistrictController::class,'addDistrict'])->name('addDistrict');
   Route::get('getAllDistrict',[DistrictController::class,'getAllDistrict'])->name('getAllDistrict');
   Route::post('getDistrictDetails',[DistrictController::class,'getDistrictDetails'])->name('getDistrictDetails');
   Route::post('editDistrict',[DistrictController::class,'editDistrict'])->name('editDistrict');
   Route::post('deleteDistrict',[DistrictController::class,'deleteDistrict'])->name('deleteDistrict');
   // ?=========================================================================================//

    // ?==========================Master Education ==============================// 
    Route::get('education', [EducationController::class, 'education'])->name('admin.education');
    Route::post('addEducation',[EducationController::class,'addEducation'])->name('addEducation');
    Route::get('getAllEducation',[EducationController::class,'getAllEducation'])->name('getAllEducation');
    Route::post('getEducationDetails',[EducationController::class,'getEducationDetails'])->name('getEducationDetails');
    Route::post('editEducation',[EducationController::class,'editEducation'])->name('editEducation');
    Route::post('deleteEducation',[EducationController::class,'deleteEducation'])->name('deleteEducation');
   // ?=========================================================================================//

   //** ======================= Education Specialization ===================== */
   Route::get('eduspecialization', [EduSpecialController::class, 'eduspecialization'])->name('admin.eduspecialization');
   Route::post('addEduSpe',[EduSpecialController::class,'addEduSpe'])->name('addEduSpe');
   Route::get('getAllEduSpe',[EduSpecialController::class,'getAllEduSpe'])->name('getAllEduSpe');
   Route::post('getEduSpeDetails',[EduSpecialController::class,'getEduSpeDetails'])->name('getEduSpeDetails');
   Route::post('editEduSpe',[EduSpecialController::class,'editEduSpe'])->name('editEduSpe');
   Route::post('deleteEduSpe',[EduSpecialController::class,'deleteEduSpe'])->name('deleteEduSpe');
   //**====================================================================== */

   
  
    
  
   Route::get('eduinstitute', [AdminController::class, 'eduinstitute'])->name('admin.eduinstitute');
   Route::get('resumesource', [AdminController::class, 'resumesource'])->name('admin.resumesource');
   Route::post('setTheme',[AdminController::class,'setTheme'])->name('admin.setTheme');

});


Route::group(['prefix' => 'recruiter', 'middleware' => ['isRecruiter', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [RecruiterController::class, 'index'])->name('recruiter.dashboard');
    Route::get('settings', [RecruiterController::class, 'settings'])->name('recruiter.settings');
});

Route::group(['prefix' => 'hod', 'middleware' => ['isHod', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [HodController::class, 'index'])->name('hod.dashboard');
    Route::get('settings', [HodController::class, 'settings'])->name('hod.settings');
});
