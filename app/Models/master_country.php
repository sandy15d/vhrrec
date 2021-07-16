<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_country extends Model
{
    use HasFactory;
    protected $table = 'master_country';
    protected $primaryKey = 'CountryId';
    public $timestamps = false;
    protected $fillable = [
        'CountryName',
        'CountryCode',
        'Status',
        'CreatedBy',
    ];
}
