<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_headquarter extends Model
{
    use HasFactory;
    protected $table = 'master_headquater';
    protected $primaryKey = 'HqId';
    public $timestamps = false;
    protected $fillable = [
        'HqId',
        'HqName',
        'StateId',
        'CompanyId',

    ];
}
