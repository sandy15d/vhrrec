<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_company extends Model
{
    use HasFactory;
    protected $fillable = [
        'CompanyName',
        'CompanyCode',
        'Address',
        'Phone',
        'Status',
        'CreatedTime',
        'CreatedBy',
    ];
}
