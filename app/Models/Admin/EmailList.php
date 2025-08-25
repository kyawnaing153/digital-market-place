<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'parent_id',
        'unique_id',
        'list_name',
    ];
}
