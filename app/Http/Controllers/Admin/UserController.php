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

    public function getAllResumeSource()
    {
        $ResumeSource = master_user::all();
        return Datatables::of($ResumeSource)
            ->addIndexColumn()
            ->addColumn('actions', function ($ResumeSource) {
                if ($ResumeSource['Editable'] == 1) {
                    return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $ResumeSource['ResumeSouId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
             <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $ResumeSource['ResumeSouId'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
                } else {
                    return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $ResumeSource['ResumeSouId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>';
                }
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ?========================Get Education Details for Edit ========================//

    public function getResumeSourceDetails(Request $request)
    {
        $ResumeSouId = $request->ResumeSouId;
        $ResumeSourceDetail = master_user::find($ResumeSouId);
        return response()->json(['ResumeSourceDetail' => $ResumeSourceDetail]);
    }

    // ?=====================Update Education Details===================
    public function editResumeSource(Request $request)
    {
        $ResumeSouId = $request->RId;
        $validator = Validator::make($request->all(), [
            'editResumeSource' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        } else {
            $ResumeSource = master_user::find($ResumeSouId);
            $ResumeSource->ResumeSource = $request->editResumeSource;
            $ResumeSource->Status = $request->editStatus;
            $query = $ResumeSource->save();
            if (!$query) {
                return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
            } else {
                return response()->json(['status' => 200, 'msg' => 'Resume Source data has been changed successfully.']);
            }
        }
    }

    public function deleteResumeSource(Request $request)
    {
        $ResumeSouId = $request->ResumeSouId;
        $query = master_user::find($ResumeSouId)->delete();
        if (!$query) {
            return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
        } else {
            return response()->json(['status' => 200, 'msg' => 'Institute data has been Deleted.']);
        }
    }
}
