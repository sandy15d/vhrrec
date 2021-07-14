<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\CompanyController;
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
   // ! =====================================================================//

    Route::get('country', [AdminController::class, 'country'])->name('admin.country');
    Route::get('state', [AdminController::class, 'state'])->name('admin.state');
    Route::get('district', [AdminController::class, 'district'])->name('admin.district');
    Route::get('education', [AdminController::class, 'education'])->name('admin.education');
    Route::get('eduspecialization', [AdminController::class, 'eduspecialization'])->name('admin.eduspecialization');
    Route::get('eduinstitute', [AdminController::class, 'eduinstitute'])->name('admin.eduinstitute');
    Route::get('resumesource', [AdminController::class, 'resumesource'])->name('admin.resumesource');
    Route::get('importdata', [AdminController::class, 'importdata'])->name('admin.importdata');
});


Route::group(['prefix' => 'recruiter', 'middleware' => ['isRecruiter', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [RecruiterController::class, 'index'])->name('recruiter.dashboard');
    Route::get('settings', [RecruiterController::class, 'settings'])->name('recruiter.settings');
});

Route::group(['prefix' => 'hod', 'middleware' => ['isHod', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [HodController::class, 'index'])->name('hod.dashboard');
    Route::get('settings', [HodController::class, 'settings'])->name('hod.settings');
});
