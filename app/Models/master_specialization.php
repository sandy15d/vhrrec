<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_specialization extends Model
{
    use HasFactory;
    protected $table = 'master_specialization';
    protected $primaryKey = 'SpId';
    public $timestamps = false;
    protected $fillable = [
        'SpId',
        'EducationId',
        'Specialization',
        'Status',

    ];
}
