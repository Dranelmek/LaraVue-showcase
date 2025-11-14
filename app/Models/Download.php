<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    // a simple record that has a foreign key to user
    // and stores data about a download a user made

    protected $fillable = [
        'user_id',
        'name',
        'format',
        'quality'
    ];
}
