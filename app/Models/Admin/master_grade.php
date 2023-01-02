<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_grade extends Model
{
    use HasFactory;
    protected $table = 'master_grade';
    protected $primaryKey = 'GradeId';
    public $timestamps = false;
    protected $fillable = [
        'GradeId',
        'GradeValue',
        'CompanyId',
        'GadeStatus'

    ];
}
