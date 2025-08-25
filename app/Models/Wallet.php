<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Wallet extends Model
{
    use HasUuids,HasFactory;
    public $fillable = [
        'id',
        'user_id',
        'type',
        'credit',
        'debit',
    ];


    public static $searchable = [
        'id'=> 'id',
        'user_id'=> 'user_id',
        'type'=> 'type',
        'credit'=> 'credit',
        'debit'=> 'debit',
    ];

    public function getStatusStrAttribute()
    {
        if($this->status == 1)
        return 'Withdrawal completed!';
        elseif($this->status == 2)
        return 'Reject';
        else
        return 'Pending';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
