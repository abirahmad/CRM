<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'title',
        'link',
        'unit_id',
        'created_by'
    ];
    
    public function createdBy()
    {
        return $this->belongsTo(Contact::class, 'created_by');
    }
}
