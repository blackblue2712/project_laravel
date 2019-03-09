<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Category;
class CategoryController extends Controller
{
    public function getAdd(){
    	$cates = Category::all()->toArray();
    	return view('admin.category.add', ['cates' => $cates]);
    }

    public function postAdd(CategoryRequest $req){
    	$cate = new Category;

    	$cate->name 		= $req->txtCateName;
    	$cate->alias 		= changeTitle($req->txtCateName);
    	$cate->keywords 	= $req->txtKeywords;
    	$cate->order 		= $req->txtOrder;
    	$cate->parent_id 	= $req->parent_id;
    	$cate->description 	= $req->description;
    	$cate->parent_id 	= $req->parent_id;

    	$cate->save();
    	return redirect()->route('admin.category.add')->with(['mess' => 'Done', 'level' => 'success']);
    }

    public function getList(){
    	$cates = Category::select('id', 'parent_id', 'name')->get();
    	return view('admin.category.list', ['cates' => $cates]);
    }

    public function getDelete($id){
    	$parent = Category::where('parent_id', $id)->count();
    	if($parent == 0){
    		$cate = Category::find($id);
	    	$cate->delete();
	    	return redirect('admin/category/list')->with(['mess' => 'Xoá thành công', 'level' => 'success']);
    	}else{
    		echo '<script>alert("Sorry, you can not delete this category");';
    		echo 'window.location="';
    		echo route('admin.category.list');
    		echo '"</script>';
    	}
    }

    public function getEdit($id){
    	$cates = Category::select('id', 'parent_id', 'name')->get();
    	$data  = Category::find($id);
    	return view('admin.category.edit', ['cates' => $cates, 'data' => $data, 'id' => $id]);
    }
    public function postEdit($id, Request $req){
		// Validate data
    	$this->validate($req,
    		[
    			'txtCateName' => 'required'
    		],
    		[
    			'txtCateName.required' => 'Please eneter category name'
    		]
    	);

		// Save category
		$cate 				= Category::find($id);

		$cate->name 		= $req->txtCateName;
    	$cate->alias 		= changeTitle($req->txtCateName);
    	$cate->keywords 	= $req->txtKeywords;
    	$cate->order 		= $req->txtOrder;
    	$cate->parent_id 	= $req->parent_id;
    	$cate->description 	= $req->description;
    	$cate->parent_id 	= $req->parent_id;

    	$cate->save();
		return redirect()->route('admin.category.edit', $id)->with(['mess' => 'Done', 'level' => 'success']);
		
    }
}
