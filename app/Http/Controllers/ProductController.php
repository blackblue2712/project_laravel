<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Category;
use App\ProductImages;
use Auth;
class ProductController extends Controller
{
    public function getList(){
    	$products  = Product::all();
    	return view('admin.product.list', ['products' => $products]);
    }

    public function getAdd(){
    	$category = Category::select('id', 'name', 'parent_id')->get();
    	return view('admin.product.add', ['cates' => $category]);
    }

    public function postAdd(Request $req){
    	$product = new Product;
        $this->validate($req, 
            [
                'txtName' => 'required|unique:product,name',
                'txtPrice' => 'required'
            ],
            [
                'txtName.required' => 'Please enter product name',
                'txtName.unique' => 'The product name already exists',
                'txtPrice.required' => 'Please enter price',
            ]
        );

    	if($req->hasFile('fImages')){
    		$this->validate($req,
    			['fImages' => 'image'],
    			['fImages.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)']
    		);
    		
    		$file = $req->file('fImages');	
    		$filename = $file->getClientOriginalName();
    		$filenameUpload = randomName() . '-' . $filename;
    		$pathUploadTo = 'upload/products';
    		$file->move($pathUploadTo, $filenameUpload);

    		$product->image = $filenameUpload;
    	}

    	
    	$product->name         = $req->txtName;
    	$product->alias        = changeTitle($req->txtName);
    	$product->price        = $req->txtPrice;
    	$product->intro        = $req->txtIntro;
    	$product->content      = $req->txtContent;
    	$product->keywords     = $req->txtKeywords;
    	$product->description  = $req->description;
    	$product->user_id      = Auth::user()->id;
    	$product->cate_id      = $req->cate_id;
        $product->save();

        if($req->hasFile('fImagesProduct')){
            $product_id = $product->id; 
            foreach ($req->fImagesProduct as $file) {
                $product_img = new ProductImages;
                if(isset($file)){  
                    $filename = $file->getClientOriginalName();
                    $filenameUpload = randomName() . '-' . $filename;
                    $pathUploadTo = 'upload/products/detail';
                    $file->move($pathUploadTo, $filenameUpload);

                    $product_img->image = $filenameUpload;
                    $product_img->product_id = $product_id;
                    $product_img->save();
                } 
            }
        }
    	return redirect('admin/product/add')->with(['mess' => 'Done', 'level' => 'success']);
    }

    public function getEdit($id){
        $product     = Product::find($id);
        $product_img = $product->pimages()->get();
        $category    = Category::all();
        return view('admin.product.edit', ['product' => $product, 'cates' => $category, 'product_img' => $product_img]);
    }

    public function postEdit(Request $req, $id){
        $product = Product::find($id);
        $this->validate($req, 
            [
                'txtName' => 'required|unique:product,name,'.$id,
                'txtPrice' => 'required'
            ],
            [
                'txtName.required' => 'Please enter product name',
                'txtName.unique' => 'The product name already exists',
                'txtPrice.required' => 'Please enter price',
            ]
        );
        if($req->hasFile('fImages')){
            $this->validate($req,
                ['fImages' => 'image'],
                ['fImages.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)']
            );

            $pathUploadTo = 'upload/products';
            // Delete old file
            unlink($pathUploadTo . '/'  . $product->image);

            // Add new file and upload to pathUpload
            $file = $req->file('fImages');  
            $filename = $file->getClientOriginalName();
            $filenameUpload = randomName() . '-' . $filename;
            $file->move($pathUploadTo, $filenameUpload);

            $product->image = $filenameUpload;
        }

        // Check file detail
        if($req->hasFile('fImagesEditProduct')){
            $this->validate($req, 
                [
                    'fImagesEditProduct.*' => 'image'
                ],
                [
                    'fImagesEditProduct.*.image' => 'The files must be image(jpeg, png, bmp, gif or svg)'
                ]
            );

            foreach ($req->fImagesEditProduct as $file) {
                $product_img_edit   = new ProductImages;
                $pathUploadToEdit   = 'upload/products/detail';
                $filenameEdit       = $file->getClientOriginalName();
                $filenameUploadEdit = randomName() . '-' . $filenameEdit;

                // Upload
                $file->move($pathUploadToEdit, $filenameUploadEdit);

                $product_img_edit->image      = $filenameUploadEdit;
                $product_img_edit->product_id = $id;
                $product_img_edit->save();
            }

        }

        // Edit in database
        $product->name          = $req->txtName;
        $product->alias         = changeTitle($req->txtName);
        $product->price         = $req->txtPrice;
        $product->intro         = $req->txtIntro;
        $product->content       = $req->txtContent;
        $product->keywords      = $req->txtKeywords;
        $product->description   = $req->description;
        $product->user_id       = Auth::user()->id;
        $product->cate_id       = $req->cate_id;

        $product->save();
        return redirect("admin/product/edit/$id")->with(['mess' => 'Done', 'level' => 'success']);   
    }

    public function getDelete($id){
        $product_detail = Product::find($id)->pimages()->get();
        if(!empty($product_detail)){
            foreach ($product_detail as $value) {
                @unlink('upload/products/detail/'.$value->image);
            }
        }
        $product = Product::find($id);
        @unlink('upload/products/'.$product->image);
        $product->delete();
        return redirect('admin/product/list')->with(['level' => 'success', 'mess' => 'Delete success']);
    }

}


