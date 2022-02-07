<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function Import()
    {
        DB::beginTransaction();
        $connection = DB::connection('mysql3');
        $getMRF = $connection->table('manpowerrequisition')->select('*')->get();
        dd($getMRF);

    }
}
