<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    function index()
    {
        return view('admin.index');
    }

    function settings()
    {
        return view('admin.settings');
    }

    function company()
    {
       $companydata = Http::get("https://www.vnrseeds.co.in/hrims/RcdDetails?action=Details&val=Company");
        return view('admin.company',['collection'=>$companydata['company_list']]);
    }

    function country()
    {
        return view('admin.country');
    }

    function state()
    {
        return view('admin.state');
    }

    function district()
    {
        return view('admin.district');
    }

    function education()
    {
        return view('admin.education');
    }

    function eduspecialization()
    {
        return view('admin.eduspecialization');
    }

    function eduinstitute()
    {
        return view('admin.eduinstitute');
    }

    function resumesource()
    {
        return view('admin.resumesource');
    }
    
    function importdata()
    {
        return view('admin.importdata');
    }
}
