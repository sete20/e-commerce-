<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class color extends Model
{
    protected $table= 'colors';
    protected $fillable = [
        'name_ar',
        'name_en',
        'color',
        
    ];
}
