<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
	protected $table    = 'products';
	protected $fillable = [
		'title',
		'photo',
		'content',
		'department_id',
		'trade_id',
		'manu_id',
		'color_id',
		'size_id',
		'currency_id',
		'price',
		'stock',
		'start_at',
		'end_at',
		'start_offer_at',
		'end_offer_at',
		'price_offer',
		'other_data',
		'weight',
		'weight_id',
		'status',
		'reason',
	];
}
