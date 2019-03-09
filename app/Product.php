<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $timestamp = false;

    public function category(){
    	return $this->belongsTo('App\Category', 'cate_id', 'id');
    }

    public function pimages () {
    	return $this->hasMany('App\ProductImages', 'product_id', 'id');
    }
}
