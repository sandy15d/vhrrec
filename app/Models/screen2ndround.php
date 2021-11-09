<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class screen2ndround extends Model
{
    use HasFactory;
    protected $table = 'screen2ndround';
    protected $primaryKey = 'SScId';
    public $timestamps = false;
    protected $fillable = [
        'SScId',
        'ScId'
    ];
}
