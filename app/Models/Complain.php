<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $fillable = [
        'site_id',
        'unit_id',
        'created_by',
        'message',
        'images',
        'reply_message',
        'status'
    ];


    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
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
            $print .= "<span class='badge badge-success'>Resolved</span>";
        }
        return $print;
    }
}
