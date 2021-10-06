<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'link',
        'duration',
        'image',
        'unit_id',
        'created_by'
    ];
    
    public function createdBy()
    {
        return $this->belongsTo(Contact::class, 'created_by');
    }
}
