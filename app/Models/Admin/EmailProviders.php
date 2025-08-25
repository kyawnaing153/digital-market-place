<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailProviders extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'name',
        'slug',
        'credentials',
        'is_active',
        'image',
        'is_connect',
    ];

    public function getlist()
    {
        return $this->hasMany(EmailList::class, 'parent_id','id');
    }
}
