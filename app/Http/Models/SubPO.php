<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubPO extends Model
{	
	use SoftDeletes;

    protected $table = "sub_po";
    protected $primaryKey = 'id';
}
