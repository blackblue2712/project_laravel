<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\ProductImages;


class AjaxController extends Controller
{
    public function getDeleteImage($id){
        if(Request::ajax()){
            $idImage = (int)Request::get('idImageDelete');
            $product_img = ProductImages::find($idImage);

            if(!empty($product_img)){
                $imgPath = 'upload/products/detail/'.$product_img->image;
                if(file_exists($imgPath)){
                    @unlink($imgPath);
                }
                $product_img->delete();
            }
        }
        echo "Done";
    }
}
