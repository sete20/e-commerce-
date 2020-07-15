<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    protected $table = 'states';
    protected $fillable = [
        'state_name_ar',
        'state_name_en',
        'country_id',
        'city_id',
    ];
    public function city_id(){
        return $this->hasOne('App\model\city','id','city_id');
    }
    public function country_id(){
        return $this->hasOne('App\model\country','id','country_id');

    }
}
