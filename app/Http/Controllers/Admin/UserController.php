<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\master_user;
use App\Models\master_employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use DataTables;

use function App\Helpers\getFullName;

class UserController extends Controller
{
    public function userlist()
    {

        $company_list = DB::table("master_company")->orderBy('CompanyId', 'asc')->pluck("CompanyCode", "CompanyId");
        return view('admin.userlist', compact('company_list'));
    }


    public function getEmployee(Request $request)
    {


        $Employee = master_employee::select(
            DB::raw("CONCAT(Fname,' ',Lname) AS name"),
            'EmployeeID'
        )
            ->where('CompanyId', $request->CompanyId)
            ->where('EmpStatus', 'A')
            ->pluck('name', 'EmployeeID');
        return response()->json($Employee);
    }


    public function getEmployeeDetail(Request $request)
    {
        $EmployeeID = $request->EmployeeID;
        $EmployeeDetail = master_employee::find($EmployeeID);
        return response()->json(['EmployeeDetail' => $EmployeeDetail]);
    }

    // ?===============Insert User records in Database===================
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'Employee' => 'required',
            'Username' => 'required',
            'Password' => 'required',
            'UserType' => 'required',
            'Contact' => 'required',
            'Email' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $User = new master_user;
            $User->id = $request->Employee;
            $User->name = getFullName($request->Employee);
            $User->Username = $request->Username;
            $User->email = $request->Email;
            $User->role = $request->UserType;
            $User->Contact = $request->Contact;
            $User->Status = $request->Status;
            $User->password =  Hash::make($request->Password);

            $query = $User->save();

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'New User has been successfully created.']);
            }
        }
    }

    // ?====================Get All Education Data From Datatabse=====================

    public function getAllUser()
    {
        $User = master_user::all();
        return Datatables::of($User)
            ->addIndexColumn()
            ->addColumn('actions', function ($User) {
            
                    return '<button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $User['id'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button> <button class="btn btn-sm btn-outline-warning font-12 cngpwd" data-id="' . $User['id'] . '"><i class="fadeIn animated bx bx-key"></i></button> <button class="btn btn-sm btn-outline-info font-12 cngpwd" data-id="' . $User['id'] . '"><i class="fadeIn animated bx bx-lock"></i></button>'; 
            })

            ->addColumn('UserType',function($User){
                if($User['role']=='H'){
                    return 'Employee';
                }elseif($User['role']=='R'){
                    return 'Recruiter';
                }elseif ($User['role']=='A') {
                    return 'Admin';
                }
            })
            ->rawColumns(['actions','UserType'])
            ->make(true);
    }


    public function deleteUser(Request $request)
    {
        $UserId = $request->UserId;
        $query = master_user::find($UserId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Institute data has been Deleted.']);
        }
    }
}
