<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'id',
        'key',
        'short_value',
        'long_value',
        'type',
        'is_active',
    ];

    public function getFileAttribute($path)
    {
        if ($path != "")
            return \Storage::url($path);

        return $path;
    }

    public function save(array $options = [])
    {
        if (request()->hasFile("image") && request()->file("image")->isValid()) {
            $this->image = request()->file("image")->store('site_images');
        }
        return parent::save();
    }

    public function folderPath()
    {
        $route = explode(".", \Request::route()->getName())[1] ?? "Other";
        $currentMonthYear = date("FY");
        return "site_images/" . strtolower($currentMonthYear);
    }
}
