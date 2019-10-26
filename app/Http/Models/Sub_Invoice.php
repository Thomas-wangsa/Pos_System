<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sub_Invoice extends Model
{
	use SoftDeletes;
    protected $table = "sub_invoice";
}
