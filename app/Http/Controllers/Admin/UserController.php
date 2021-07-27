<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\master_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;

class UserController extends Controller
{
 public function userlist()
 {
     return view('admin.userlist');
 }

 // ?===============Insert User records in Database===================
 public function addUser(Request $request)
 {
     $validator = Validator::make($request->all(), [
         'ResumeSource' => 'required',

     ]);
     if ($validator->fails()) {
         return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
     } else {
         $ResumeSource = new master_user;
         $ResumeSource->ResumeSource = $request->ResumeSource;
         $ResumeSource->Editable = 1;
         $ResumeSource->Status = $request->Status;
         $query = $ResumeSource->save();

         if (!$query) {
             return response()->json(['status' => 400, 'msg' => 'Something went wrong..!!']);
         } else {
             return response()->json(['status' => 200, 'msg' => 'New Resume Source has been successfully created.']);
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
             if($ResumeSource['Editable']==1){
             return '<button class="btn btn-sm  btn-outline-primary font-13 edit" data-id="' . $ResumeSource['ResumeSouId'] . '" id="editBtn"><i class="fadeIn animated bx bx-pencil"></i></button>  
             <button class="btn btn-sm btn btn-outline-danger font-13 delete" data-id="' . $ResumeSource['ResumeSouId'] . '" id="deleteBtn"><i class="fadeIn animated bx bx-trash"></i></button>';
             }else{
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
