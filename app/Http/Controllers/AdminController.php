<?php

namespace App\Http\Controllers;



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
