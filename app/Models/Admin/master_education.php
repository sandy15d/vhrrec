<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_education extends Model
{
    use HasFactory;
    protected $table = 'master_education';
    protected $primaryKey = 'EducationId';
    public $timestamps = false;
    protected $fillable = [
        'EducationId',
        'EducationName',
        'EducationCode',
        'EducationType',
        'IsDeleted'

    ];
}
