<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Category;
class CategoryController extends Controller
{
    public function getAdd(){
    	return view('admin.category.add');
    }

    public function postAdd(CategoryRequest $req){
    	$cate = new Category;

    	$cate->name 		= $req->txtCateName;
    	$cate->alias 		= changeTitle($req->txtCateName);
    	$cate->keywords 	= $req->txtKeywords;
    	$cate->order 		= $req->txtOrder;
    	$cate->parent_id 	= 1;
    	$cate->description 	= $req->description;

    	$cate->save();
    	return redirect()->route('admin.category.add')->with(['mess' => 'Done', 'level' => 'success']);
    }
}
