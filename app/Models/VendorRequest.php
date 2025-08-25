<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'answers'
    ];

    public function getStatusStrAttribute()
    {
        if($this->status == 1)
        return 'accepted';
        elseif($this->status == 2)
        return 'rejected';
        else
        return 'pending';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
