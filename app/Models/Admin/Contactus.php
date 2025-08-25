<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    public $table = 'contactus';

    public $fillable = [
        'id',
        'name',
        'email',
        'message',
        'type',
        'is_replay'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'message' => 'string',
        'type' => 'string',
        'is_replay' => 'integer'
    ];

    public static array $rules = [
        
    ];

    
}
