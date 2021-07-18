<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_department extends Model
{
    use HasFactory;
    protected $table = 'master_department';
    protected $primaryKey = 'DepratmentId';
    public $timestamps = false;
    protected $fillable = [
        'DepartmentId',
        'DepartmentName',
        'DepartmentCode',
        'CompanyId',
        'DeptStatus'

    ];
}
