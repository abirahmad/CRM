<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'site_id',
        'unit_id',
        'responsible_name',
        'responsible_phone_no',
        'type',
        'structure_type_id',
        'size',
        'address',
        'product_usage_qty',
        'comment',
        'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(Contact::class, 'created_by');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function structure()
    {
        return $this->belongsTo(StructureType::class, 'structure_type_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
