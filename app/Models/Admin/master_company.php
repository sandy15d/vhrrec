<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_company extends Model
{
    protected $table = 'master_company';
    protected $primaryKey = 'CompanyId';
    public $timestamps = false;
    protected $fillable = [
        'CompanyName',
        'CompanyCode',
        'Address',
        'Phone',
        'Status',
        'CreatedBy',
    ];
}
