<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ThemeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use DataTables;

use function App\Helpers\getDepartmentCode;
use function App\Helpers\getDesignationCode;
use function App\Helpers\getDistrictName;
use function App\Helpers\getFullName;
use function App\Helpers\getStateCode;

class AdminController extends Controller
{
    function index()
    {
        return view('admin.index');
    }

    function mrf()
    {
        return view('admin.mrf');
    }


    
    function getAllMRF()
    {
        $mrf = DB::table('manpowerrequisition as mr')
            ->where('MRFId', '!=', 0)
            ->where('Status', '!=', 'Close')
            ->select(['mr.*']);

        return Datatables::of($mrf)
            ->addIndexColumn()
            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New';
                } else {
                    return 'Replacement';
                }
            })
            ->editColumn('DepartmentId', function ($mrf) {
                return getDepartmentCode($mrf->DepartmentId);
            })
            ->editColumn('DesigId', function ($mrf) {
                return getDesignationCode($mrf->DesigId);
            })
            ->editColumn('LocationIds', function ($mrf) {
                $location = unserialize($mrf->LocationIds);
                $loc = '';
                foreach ($location as $key => $value) {
                    $loc .= getDistrictName($value['city']) . ' ';
                    $loc .= getStateCode($value['state']) . ' - ';
                    $loc .= $value['nop'].', ';
                    $loc . '<br>';
                }
                return $loc;
            })
            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })

            ->addColumn('CreatedBy', function ($mrf) {

                return getFullName($mrf->CreatedBy);
            })

            ->addColumn('Status', function ($mrf) {
                return '<select name="mrfstatus" id="mrfstatus'.$mrf->MRFId.'" class="form-control form-select form-select-sm  d-inline" disabled onchange="chngmrfsts()" style="width: 80px; ">
                <option value="New"></option>
                <option>Approved</option>
                <option>On Hold</option>
                <option>Rejected</option>
            </select><i class="fa fa-pencil-square-o text-primary d-inline" aria-hidden="true"
            id="msedit'.$mrf->MRFId.'" onclick="editmstst('.$mrf->MRFId.',this)"
            style="font-size: 16px;cursor: pointer;"></i>';
            })
            ->rawColumns(['Status'])
            ->make(true);
    }

    function setTheme(Request $request)
    {
        $ThemeStyle = $request->ThemeStyle;
        if ($ThemeStyle != '') {
            if ($ThemeStyle == 'lightmode') {
                $Style = 'light-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'darkmode') {
                $Style = 'dark-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'semidark') {
                $Style = 'semi-dark';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'minimaltheme') {
                $Style = 'minimal-theme';
                $SidebarColor = '';
            } elseif ($ThemeStyle == 'sidebarcolor1') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor1';
            } elseif ($ThemeStyle == 'sidebarcolor2') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor2';
            } elseif ($ThemeStyle == 'sidebarcolor3') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor3';
            } elseif ($ThemeStyle == 'sidebarcolor4') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor4';
            } elseif ($ThemeStyle == 'sidebarcolor5') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor5';
            } elseif ($ThemeStyle == 'sidebarcolor6') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor6';
            } elseif ($ThemeStyle == 'sidebarcolor7') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor7';
            } elseif ($ThemeStyle == 'sidebarcolor8') {
                $Style = '';
                $SidebarColor = 'color-sidebar sidebarcolor8';
            }


            $data = array(
                'ThemeStyle' => $Style,
                'SidebarColor' => $SidebarColor,
                'UserId' => Auth::user()->id,
            );
            $query =  ThemeDetail::updateOrCreate(['UserId' => Auth::user()->id], $data);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                $request->session()->forget('ThemeStyle');
                $request->session()->forget('SidebarColor');
                $request->session()->put('ThemeStyle', $Style);
                $request->session()->put('SidebarColor', $SidebarColor);
                return response()->json(['status' => 200, 'msg' => 'New Theme has been successfully Applied.']);
            }
        }
    }

    function eduinstitute()
    {
        return view('admin.eduinstitute');
    }

    function resumesource()
    {
        return view('admin.resumesource');
    }
}
