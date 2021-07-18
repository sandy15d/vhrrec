<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_designation extends Model
{
    use HasFactory;
    protected $table = 'master_designation';
    protected $primaryKey = 'DesigId';
    public $timestamps = false;
    protected $fillable = [
        'DesigId',
        'DesigName',
        'DesigCode',
        'DepartmentId',
        'CompanyId',
        'DesigStatus'

    ];
}
