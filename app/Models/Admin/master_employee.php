<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_employee extends Model
{
    use HasFactory;
    protected $table = 'master_employee';
    protected $primaryKey = 'EmployeeID';
    public $timestamps = false;
    protected $fillable = [
        'EmpCode',
        'EmpType',
        'EmpStatus',
        'Title',
        'Fname',
        'Sname',
        'Lname',
        'CompanyId',
        'GradeId',
        'DepartmentId',
        'DesigId',
        'RepEmployeeID',
        'Contact',
        'Email', 
        'Gender',
        'Married',
        'DR',
        'Location',
        'DOJ',
        'DateOfSepration',
        'CTC',
        'LastUpdated',
    ];
}
