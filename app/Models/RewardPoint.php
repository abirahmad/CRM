<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    protected $fillable = [
        'contact_id',
        'project_id',
        'given_by',
        'point'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function givenBy()
    {
        return $this->belongsTo(Admin::class, 'given_by');
    }
}
