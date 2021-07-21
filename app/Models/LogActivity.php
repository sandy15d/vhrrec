<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $table = 'activity_log';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'log_name', 'description', 'subject_type', 'ip', 'agent', 'user_id'
    ];
}
