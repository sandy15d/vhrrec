<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunicationController extends Controller
{
    function communication_control()
    {
        return view('admin.communication');
    }

    public function setCommunication(Request $request)
    {
        $id = $request->id;
        $query = DB::table('communication_control')
            ->where('id', $id)
            ->get();
        $is_active = $query[0]->is_active;
        if ($is_active == 0) {
            DB::table('communication_control')->where('id', $id)->update(array('is_active' => 1));
            return json_encode(array('status'=>200));
        } else {
            DB::table('communication_control')->where('id', $id)->update(array('is_active' => 0));
            return json_encode(array('status'=>200));
        }
    }
}
