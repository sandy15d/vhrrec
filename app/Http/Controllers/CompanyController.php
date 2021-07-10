<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\master_company;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    function company()
    {
        return view('admin.company');
    }
}
