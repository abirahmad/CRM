<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReference extends Model
{
    public $table = "contact_reference";

    protected $fillable = [
        'contact_id',
        'name',
        'relation_type_id',
        'email',
        'phone',
        'birthdate',
        'marriage_date',
    ];

    public function relation()
    {
        return $this->belongsTo(RelationType::class, 'relation_type_id', 'id');
    }
}
