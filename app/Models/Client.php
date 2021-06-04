<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod',
        'name',
        'city_id',
    ];



    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeFcity($query,$filter)
    {
        if ($filter) {
            $query->where("city_id",$filter);
        }
    }
}
