<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $fillable=[
        'upazila_id',
        'name',
        'message',
        'bn_name',
        'lat',
        'lon',
        'website',
    ];
}
