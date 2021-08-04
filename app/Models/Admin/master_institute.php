<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_institute extends Model
{
    use HasFactory;
    protected $table = 'master_institute';
    protected $primaryKey = 'InstituteId';
    public $timestamps = false;
    protected $fillable = [
        'InstituteId',
        'InstituteName',
        'InstituteCode',
        'StateId',
        'DistrictId',
        'Category',
        'Type',
        'Status',

    ];
}
