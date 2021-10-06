<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable=[
        'divisions_id',
        'name',
        'bn_name',
        'late',
        'lon',
        'website',
    ];
}
