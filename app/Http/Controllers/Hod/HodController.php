<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\ThemeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

use function App\Helpers\getFullName;

class HodController extends Controller
{
    function index()
    {
        return view('hod.index');
    }



    public function mrfbyme()
    {
        $mrf = DB::table('manpowerrequisition')
            ->Join('master_designation', 'manpowerrequisition.DesigId', '=', 'master_designation.DesigId')
            ->where('manpowerrequisition.CreatedBy',Auth::user()->id)
            ->orWhere('manpowerrequisition.OnBehalf',Auth::user()->id)
            ->select('manpowerrequisition.MRFId', 'manpowerrequisition.Type', 'manpowerrequisition.JobCode', 'manpowerrequisition.CreatedBy', 'master_designation.DesigName', 'manpowerrequisition.Status', 'manpowerrequisition.CreatedTime');
       
            return datatables()::of($mrf)
            ->addIndexColumn()
            ->addColumn('MRFDate', function ($mrf) {
                return date('d-m-Y', strtotime($mrf->CreatedTime));
            })
            ->addColumn('CreatedBy', function ($mrf) {
                if ($mrf->Type == 'N_HrManual' || $mrf->Type == 'R_HrManual') {
                    return 'HR';
                } else {
                    return getFullName($mrf->CreatedBy);
                }
            })

            ->editColumn('Type', function ($mrf) {
                if ($mrf->Type == 'N' || $mrf->Type == 'N_HrManual') {
                    return 'New';
                } else {
                    return 'Replacement';
                }
            })

            ->addColumn('actions', function ($mrf) {
                if ($mrf->Status == 'New') {
                    return '<button class="btn btn-sm  btn-outline-info font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button> <button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $mrf->MRFId . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
                <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $mrf->MRFId . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
                } else {
                    return '<button class="btn btn-sm  btn-outline-primary font-13 view" data-id="' . $mrf->MRFId . '" id="viewBtn"><i class="fadeIn animated lni lni-eye"></i></button>';
                }
            })
            ->addColumn('chk',function(){
                return '<input type="checkbox" class="select_all">';
            })
            ->rawColumns(['actions','chk'])
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
}
