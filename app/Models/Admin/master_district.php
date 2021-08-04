<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_district extends Model
{
    use HasFactory ;
    protected $table = 'master_district';
    protected $primaryKey = 'DistrictId';
    public $timestamps = false;
    protected $fillable = [
        'DistrictId',
        'DistrictName',
        'StateId',
        'Status',
        'IsDeleted'

    ];

}
