<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\master_user;
use App\Models\Admin\master_employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use App\Helpers\LogActivity;
use App\Mail\NewUserMail;
use DataTables;
use Illuminate\Support\Facades\Mail;

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

            $userdetails = master_user::find($request->Employee);

            $role = $userdetails->role;
            if ($role == 'A') {
                $r = 'Admin';
            } elseif ($role == 'R') {
                $r = 'Recruiter';
            } else {
                $r = 'Employee';
            }
            $name = getFullName($request->Employee);
            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                LogActivity::addToLog('New User' . getFullName($request->Employee) . ' is created', 'Create');
                $details = [
                    "subject" => 'New user account created as ' . $r,
                    "Employee" => $name,
                    "Role" => $r,
                    "Username" => $request->Username,
                    "Password" => $request->Password
                ];
                Mail::to("sandeepdewangan.vspl@gmail.com")->send(new NewUserMail($details));
                return response()->json(['status' => 200, 'msg' => 'New User has been successfully created.']);
            }
        }
    }

    // ?====================Get All Education Data From Datatabse=====================

    public function getAllUser()
    {
        $User = master_user::all();
        return datatables()->of($User)
            ->addIndexColumn()
            ->addColumn('actions', function ($User) {
                return '<button class="btn btn-sm btn btn-outline-danger font-12 delete" data-id="' . $User['id'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button> <button class="btn btn-sm btn-outline-warning font-12 cngpwd" data-id="' . $User['id'] . '"><i class="fadeIn animated bx bx-key"></i></button> <button class="btn btn-sm btn-outline-info font-12 setpermission" data-id="' . $User['id'] . '"><i class="fadeIn animated bx bx-lock"></i></button>';
            })

            ->addColumn('UserType', function ($User) {
                if ($User['role'] == 'H') {
                    return 'Employee';
                } elseif ($User['role'] == 'R') {
                    return 'Recruiter';
                } elseif ($User['role'] == 'A') {
                    return 'Admin';
                }
            })
            ->rawColumns(['actions', 'UserType'])
            ->make(true);
    }


    public function deleteUser(Request $request)
    {
        $UserId = $request->UserId;
        $query = master_user::find($UserId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'User  data has been Deleted.']);
        }
    }
}
