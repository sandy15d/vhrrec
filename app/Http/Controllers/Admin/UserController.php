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
use App\Models\Admin\master_user_permission;
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
           // ->where('EmpStatus', 'A')
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
                $x = '';
                $x .= '<button class="btn btn-sm btn btn-outline-danger font-12 " ><i class="fadeIn animated bx bx-trash delete" data-id="' . $User['id'] . '" id="deleteBtn"></i></button> <button class="btn btn-sm btn-outline-primary font-12 cngpwd" data-id="' . $User['id'] . '"><i class="fadeIn animated bx bx-key"></i></button>';
                if ($User['role'] == 'R' || $User['role'] == 'A') {
                    $x .= '<button class="btn btn-sm btn-outline-info font-12 setpermission" data-id="' . $User['id'] . '"><i class="fadeIn animated bx bx-lock"></i></button>';
                }
                return $x;
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

    public function cngUserPwd(Request $request)
    {
        $UId = $request->UId;
        $validator = Validator::make($request->all(), [
            'CnfPassword' => 'required',
            'NewPassword' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {

            $query = master_user::where('id', $UId)->update(['password' => bcrypt($request->NewPassword), 'updated_at' => date('Y-m-d H:i:s')]);

            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'Password has been changed successfully.']);
            }
        }
    }


    public function getPermission(Request $request)
    {
        $UserId = $request->UserId;
        $query = DB::select("SELECT p.*,IF(ISNULL(up.PId), 'NO', 'YES') AS active FROM permission p
       left JOIN user_permission up on up.PId = p.PId AND up.UserId = $UserId");
        return response()->json(['Permission' => $query]);
    }

    public function setpermission(Request $request)
    {
        $UserId = $request->UserId;
        $permission = $request->permission;
        $sql = 0;
        $check = master_user_permission::where('UserId', $UserId);
        if ($check != null) {
            $query = $check->delete();
        }

        for ($i = 0; $i < Count($permission); $i++) {
            $UserPermission = new master_user_permission;
            $UserPermission->UserId = $UserId;
            $UserPermission->PId = $permission[$i];

            $UserPermission->save();
            $sql = 1;
        }

        if ($sql == 1) {
            return response()->json(['status' => 200, 'msg' => 'Permission has been set successfully.']);
        } else {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        }
    }
}
