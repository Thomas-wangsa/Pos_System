<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{	
	use SoftDeletes;
    protected $table = "customer";
    protected $primaryKey = 'id';
}
