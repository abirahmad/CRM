<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandRequisition extends Model
{
     protected $fillable = [
        'item_type',
        'quantity',
        'size',
        'image'
    ];
}
