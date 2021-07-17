<?php

namespace App\Models;

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
<<<<<<< HEAD
}
=======
}
>>>>>>> 72f9292659885612d09f4efc5b8dec58560322c9
