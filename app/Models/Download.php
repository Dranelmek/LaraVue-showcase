<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'format',
        'quality'
    ];
}
