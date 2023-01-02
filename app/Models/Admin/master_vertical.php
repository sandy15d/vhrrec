<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_vertical extends Model
{
    use HasFactory;
    protected $table = 'master_vertical';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = [
        'VerticalId',
        'CompanyId',
        'DepartmentId',
        'VerticalName',

    ];
}
