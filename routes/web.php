<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
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
 
    Route::get('district', [AdminController::class, 'district'])->name('admin.district');
    Route::get('education', [AdminController::class, 'education'])->name('admin.education');
    Route::get('eduspecialization', [AdminController::class, 'eduspecialization'])->name('admin.eduspecialization');
    Route::get('eduinstitute', [AdminController::class, 'eduinstitute'])->name('admin.eduinstitute');
    Route::get('resumesource', [AdminController::class, 'resumesource'])->name('admin.resumesource');

    //*====================================Master Employee ==================================//
    Route::get('employee', [EmployeeController::class, 'employee'])->name('admin.employee');
    Route::get('getAllEmployeeData', [EmployeeController::class, 'getAllEmployeeData'])->name('getAllEmployeeData');
    Route::post('syncEmployee',[EmployeeController::class,'syncEmployee'])->name('syncEmployee');
     //*====================================Master Employee ==================================//
});


Route::group(['prefix' => 'recruiter', 'middleware' => ['isRecruiter', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [RecruiterController::class, 'index'])->name('recruiter.dashboard');
    Route::get('settings', [RecruiterController::class, 'settings'])->name('recruiter.settings');
});

Route::group(['prefix' => 'hod', 'middleware' => ['isHod', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [HodController::class, 'index'])->name('hod.dashboard');
    Route::get('settings', [HodController::class, 'settings'])->name('hod.settings');
});
