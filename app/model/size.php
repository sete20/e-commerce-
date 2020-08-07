<?php

namespace App\model;
use app\model\department;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
    protected $table= 'sizes';

    protected $fillable =[
        'name_ar',
        'name_en',
        'department_id',
        'is_public',
    ];
    public function department_id(){
        return $this->hasOne('App\Model\Department', 'id', 'department_id');

        // return $this->hasOne('app\model\Department', 'id',  'department_id');
    }
}
