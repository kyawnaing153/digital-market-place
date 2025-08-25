<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function scopeFilter($query)
    {
        if (!request()->has('s') || request('s') == '' || request('filter') == '')
            return null;
        elseif (request('filter') == 'contains')
            return $query->where(request('key'), 'like', '%' . request('s') . '%');
        elseif (request('filter') == 'greaterEquals')
            return $query->where(request('key'), '>=', request('s'));
        elseif (request('filter') == 'lesserEquals')
            return $query->where(request('key'), '<=', request('s'));
        else
            return $query->where(request('key'), '=', request('s'));
    }
}
