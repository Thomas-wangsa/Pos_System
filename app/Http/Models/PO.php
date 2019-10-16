<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PO extends Model
{	
	use SoftDeletes;
    protected $table = "po";
    protected $primaryKey = 'id';
}
