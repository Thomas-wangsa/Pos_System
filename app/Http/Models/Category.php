<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $primaryKey = 'id';


    public function scopeGetConfig($query,$param=null) {
    	$query->join('users AS u_c','u_c.id','=','category.created_by')
    		->join('users AS u_u','u_u.id','=','category.updated_by');
    	if($param != null) {$query->where('name','LIKE',"%$param%");}
    	$query->select('category.*','u_c.name AS created_by_user','u_u.name AS updated_by_user');
    	return $query;
    }
}
