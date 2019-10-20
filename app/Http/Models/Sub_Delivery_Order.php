<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sub_Delivery_Order extends Model
{
	use SoftDeletes;
    protected $table = "sub_delivery_order";
}
