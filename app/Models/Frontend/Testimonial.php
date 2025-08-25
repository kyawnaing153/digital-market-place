<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
  
    public function getImageAttribute($path)
    {
        if ($path != "")
            return \Storage::url($path);

        return $path;
    }

}
