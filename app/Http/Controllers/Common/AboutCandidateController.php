<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutCandidateController extends Controller
{
    public function candidate_detail()
    {
        return view('common.candidate_detail');
    }
  
}
