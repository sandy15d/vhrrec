<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_grade extends Model
{
    use HasFactory;
    protected $table = 'core_grade';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'grade_name',
        'company_id',
        'is_active',

    ];
}
