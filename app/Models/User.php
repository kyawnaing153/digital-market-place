<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Frontend\{Product};
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    // protected $connection = 'main_mysql';

    // protected $primaryKey= 'userId';
    use SoftDeletes,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'full_name',
        'google_id',
        'google_token',
        'google_refresh_token',
        'avatar',
        'password',
        'is_email_verified',
        'email_verified_at',
        'role',
        'role_type',
        'facebook_id',
        'facebook_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getavatarAttribute($path)
    {
        if ($path != ""){
            if(!empty($this->google_id) || !empty($this->facebook_id))
                return $path;
            else
                return asset(\Storage::url($path));
        }

        return \Storage::url(getSettingShortValue('default_user_image'));
    
    }
    public function save(array $options = [])
    {
        if (request()->hasFile("image") && request()->file("image")->isValid()) {
            $this->avatar = request()->file("image")->store($this->folderPath());
        }
        return parent::save();
    }

    public function folderPath()
    {
        $route = explode(".", \Request::route()->getName())[1] ?? "Other";
        $currentMonthYear = date("FY");
        return "users/" . $currentMonthYear;
    }

    public function save_image($request)
    {
        if (
            request()->hasFile("image") && request()->file("image")->isValid()
        ) {
            $img = request()->file("image")->store($this->folderPath(), 'webadmin');
            return $img;
        }
        return;
    }


    public function getCountry()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }
    public function getProductCount()
    {
        return $this->hasMany(Product::class,'user_id','id')->where('is_active',1);
    }
    public function getProductSales()
    {
      $data = $this->hasMany(Product::class,'user_id','id')->select(\DB::raw('SUM(sale_count) as total_sales'))->first();
      return $data->total_sales;
    }

    public function getOrders()
    {
        return $this->hasMany(Order::class,'user_id','id')->orderBy('id','DESC');
    }


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

    public static $searchable = [
        'id' => 'User Id',
        'full_name' => 'Name',
        'email' => 'Email',
        'is_active' => 'Is Active',  
    ];

}
