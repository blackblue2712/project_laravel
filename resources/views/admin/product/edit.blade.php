@extends('admin.master')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <form name="adminForm" action="admin/product/edit/{{$product->id}}" method="POST" enctype="multipart/form-data">
                <div class="col-lg-7" style="padding-bottom:120px">
                @include('admin.message')                
                    <div class="form-group">
                        <label>Category Parent</label>
                        <select class="form-control" name="cate_id">
                             <?php get_cates($cates, 0, '--', $product->cate_id) ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="txtName" placeholder="Please Enter Name" value="{{$product->name}}" />
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" name="txtPrice" placeholder="Please Enter Price" value="{{$product->price}}" />
                    </div>
                    <div class="form-group">
                        <label>Intro</label>
                        <textarea class="form-control ckeditor" rows="3" name="txtIntro">{{$product->intro}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control ckeditor" rows="3" name="txtContent">{{$product->content}}</textarea>
                    </div>
                    <div class="form-group">
                        <p>
                            <label>Current image</label>
                            <img class="currentImage" src="{{ asset('upload/products/'.$product->image) }}">
                        </p>
                        <label>Images</label>
                        <input type="file" name="fImages">
                    </div>
                    <div class="form-group">
                        <label>Product Keywords</label>
                        <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords" value="{{$product->keywords}}" />
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea class="form-control" rows="3" name="description">{{$product->description}}</textarea>
                    </div>
                   <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default">Eidt</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    @foreach($product_img as $img)
                        <div id="wrap-image-{{$img->id}}">
                            <img class="image_detail" src="{{ asset('upload/products/detail/'.$img->image) }}">
                            <a class="btn btn-circle btn-danger deleteImage" href="javascript:void(0)" data-id="{{$img->id}}"><i class="fa fa-times"></i></a>
                        </div>
                    @endforeach    
                </div>
                <div class="col-md-4" style="margin-top: 20px">
                    <center><a id="moreImages" class="btn btn-sm btn-primary">More image</a></center>
                    <div id="insertMoreImages"></div>
                </div>
            </div>
        <form>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

@endsection

@section('script')
    <script type="text/javascript" language="javascript" src="admin/ckeditor/ckeditor.js" ></script>
    <script type="text/javascript">
        window.onload = function(){
            $('#moreImages').click(function(){
                $('#insertMoreImages').append('<div><input type="file" name="fImagesEditProduct[]"></div>');
            })

            // Delete images from table product_imagmes
            $('.deleteImage').click(function(){
                var idImageDelete = $(this).data('id');
                var urlImageDelete = $(this).parent().find('img').attr('src');
                var _token = $('form[name=adminForm]').find('input[name=_token]').val();
                $.ajax({
                    url: 'http://localhost/project_laravel/public/admin/product/deleteImage/' + parseInt(idImageDelete),
                    data: {idImageDelete: idImageDelete, urlImageDelete: urlImageDelete, _token: _token},
                    cache: false,
                    type: 'GET',
                    success: function (data) {
                        console.log(data)
                        if(data == 'Done'){
                            $('#wrap-image-'+idImageDelete).remove();
                        }else{
                            alert('Error occured');
                        }
                    }
                });
            }); 
        }
    </script>
@endsection

@section('css')
    <style type="text/css">
        .currentImage{
            width: 120px;
        }
        .image_detail{
            width: 200px;
            margin-bottom: 10px;
        }
    </style>
@endsection