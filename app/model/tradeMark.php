<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class tradeMark extends Model
{
	protected $table    = 'trade_marks';
	protected $fillable = [
		'name_ar',
		'name_en',
		'logo',
	];    
}
