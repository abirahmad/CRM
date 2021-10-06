<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'site_id',
        'product_id',
        'quantity',
        'date',
        'location',
        'unit_id',
        'district_id',
        'upazila_id',
        'created_by',
        'status',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Contact::class, 'created_by');
    }

    public function statusPrint()
    {
        $print = "";
        if ($this->status == 0) {
            $print .= "<span class='badge badge-danger'>Pending</span>";
        } else {
            $print .= "<span class='badge badge-success'>Done</span>";
        }
        return $print;
    }
}
