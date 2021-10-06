<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationType extends Model
{
    public $table = "relation_type";

    protected $fillable = [
        'name'
    ];
}
