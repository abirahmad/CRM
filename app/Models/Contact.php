<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contact extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone_no',
        'password',
        'fb_address',
        'designation',
        'birthdate',
        'district_id',
        'upazilla_id',
        'office_name',
        'office_address',
        'api_token',
        'verify_token',
        'language',
        'remember_token',
        'status',
        'unit_id',
        'contact_type_id',
        'total_reward_point'
    ];


    public function type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function references()
    {
        return $this->hasMany(ContactReference::class);
    }

    public function rewards()
    {
        return $this->hasMany(RewardPoint::class);
    }

    public function upazilla()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function spouse()
    {
        return $this->hasOne(ContactReference::class)->where('relation_type_id', 11);
    }

    public function children()
    {
        return $this->hasMany(ContactReference::class)->where('relation_type_id', 5);
    }

    public function statusPrint()
    {
        $print = "";
        if ($this->status == 0) {
            $print .= "<span class='badge badge-danger'>Inactive</span>";
        } else {
            $print .= "<span class='badge badge-success'>Active</span>";
        }
        return $print;
    }
}
