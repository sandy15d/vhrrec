<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_state extends Model
{
    use HasFactory;
    protected $table = 'master_state';
    protected $primaryKey = 'StateId';
    public $timestamps = false;
    protected $fillable = [
        'StateName',
        'StateCode',
        'Country',
        'Status',
        'CreatedBy',
    ];
}
