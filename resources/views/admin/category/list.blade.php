

@extends('admin.master')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Category
                    <small>List</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if(session('mess'))
                <div class="alert alert-{{session('level')}}">{{session('mess')}}</div>
            @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category Parent</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cates as $cate)
                    <tr class="odd gradeX" align="center">
                        <td>{{$cate->id}}</td>
                        <td>{{$cate->name}}</td>
                        <td>
                            @if($cate->parent_id == 0)
                                {{"None"}}
                            @else
                                <?php
                                    $parent = DB::table('category')->where('id', $cate->parent_id)->first();
                                    echo $parent->name
                                ?>
                            @endif
                            
                        </td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a class="delete-item" href="{{ URL::route('admin.category.delete', $cate->id) }}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{ URL::route('admin.category.edit', $cate->id) }}">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                    responsive: true
            });
            $('.delete-item').click(function(){
                if(window.confirm('Sure')){
                    return true;
                }
                return false;
            });
        });
    </script>
@endsection