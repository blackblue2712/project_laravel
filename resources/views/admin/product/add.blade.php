@extends('admin.master')
@section('content')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product
                    <small>Add</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <form action="admin/product/add" method="POST" enctype="multipart/form-data">
                <div class="col-lg-7" style="padding-bottom:120px">
                @include('admin.message')                   
                    <div class="form-group">
                        <label>Category Parent</label>
                        <select class="form-control" name="cate_id">
                             <?php get_cates($cates, 0, '--', old('cate_id') ) ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="txtName" placeholder="Please Enter Name" value="{{old('txtName')}}" />
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" name="txtPrice" placeholder="Please Enter Price" value="{{old('txtPrice')}}" />
                    </div>
                    <div class="form-group">
                        <label>Intro</label>
                        <textarea class="form-control ckeditor" rows="3" name="txtIntro">{{old('txtIntro')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control ckeditor" rows="3" name="txtContent">{{old('txtContent')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <input type="file" name="fImages">
                    </div>
                    <div class="form-group">
                        <label>Product Keywords</label>
                        <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords" value="{{old('txtKeywords')}}" />
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea class="form-control" rows="3" name="description">{{old('description')}}</textarea>
                    </div>
                   <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default">Product Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
                @for($i = 0; $i < 10; $i++)
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Images product detail</label>
                        <input type="file" name="fImagesProduct[]">
                    </div>
                </div>
                @endfor
            <form>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

@endsection

@section('script')
    <script type="text/javascript" language="javascript" src="admin/ckeditor/ckeditor.js" ></script>    
@endsection