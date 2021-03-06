<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{	
	use SoftDeletes;

    protected $table = "driver";
    protected $primaryKey = 'id';


    public function scopeGetConfig($query,$param=null) {
    	$query->leftjoin('users AS u_c','u_c.id','=','driver.created_by')
    		->leftjoin('users AS u_u','u_u.id','=','driver.updated_by');
    	if($param != null) {$query->where('name','LIKE',"%$param%");}
    	$query->select('driver.*','u_c.name AS created_by_user','u_u.name AS updated_by_user');
    	return $query;
    }
}
