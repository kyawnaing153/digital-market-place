<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'name',
        'designation',
        'is_checked_designation',
        'image',
        'message',
    ];
    public function save(array $options = [])
    {
        if (request()->hasFile("image") && request()->file("image")->isValid()) {
            $this->image = request()->file("image")->store($this->folderPath());
        }
        return parent::save();
    }

    public function folderPath()
    {
        return "testimonial/" . strtolower(date("FY"));
    }

    public function getImageAttribute($path)
    {
        if ($path != "")
            return \Storage::url($path);

        return $path;
    }

}
