<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'heading',
        'sub_heading',
        'image',
        'link',
        'page_name',
        'is_active',
        'type'
    ];
    public function getImageAttribute($path)
    {
        if ($path != "")
            return \Storage::url($path);

        return $path;
    }

    public function save(array $options = [])
    {
        if (request()->hasFile("image") && request()->file("image")->isValid()) {
            $this->image = request()->file("image")->store($this->folderPath());
        }
        return parent::save();
    }

    public function folderPath()
    {
        return "home/images/" . strtolower(date("FY"));
    }
}
