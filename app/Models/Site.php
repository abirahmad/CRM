<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name',
        'unit_id',
        'owner_name',
        'owner_phone_no',
        'address',
        'structure_type_id',
        'created_by',
        'status'
    ];

    public function project()
    {
        return $this->hasOne(Project::class)
        ->select('projects.id', 'projects.site_id', 'projects.product_usage_qty', 'projects.comment', 'projects.status', 'projects.size')
        ->orderBy('projects.id', 'desc');
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->select('projects.id', 'projects.site_id', 'projects.product_usage_qty', 'projects.comment', 'projects.status', 'projects.size')->orderBy('projects.id', 'desc');
    }
    
    public function total_product_usage()
    {
        // $total_product_usage = 0;
        // foreach($this->projects as $project){
        //     $total_product_usage += $project->product_usage_qty;
        // }
        // return $total_product_usage;
        $product_usage_qty = [
                        'product_usage_qty' => $this->projects->sum('product_usage_qty')
        ];
        
        // return $this->projects->sum('product_usage_qty');
        return $product_usage_qty;
    }

    public function structure()
    {
        return $this->belongsTo(StructureType::class, 'structure_type_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Contact::class, 'created_by');
    }
}
