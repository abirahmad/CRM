<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    protected $fillable = [
        'year', 'month', 'title','image'
    ];

     public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
