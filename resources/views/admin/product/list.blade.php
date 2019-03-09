@extends('admin.master')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product
                    <small>List</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Alias</th>
                        <th>Create_at</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach($products as $pd)
                        <tr class="odd gradeX" align="center">
                            <td>{{$i}}</td>
                            <td>
                                <p>{{$pd->name}}</p>
                                <img width="200" src="upload/products/{{$pd->image}}">
                            </td>
                            <td>{{$pd->category->name}}</td>
                            <td>{{ number_format($pd->price, 0, ',', '.') }}</td>
                            <td>{{$pd->alias}}</td>
                            <td>
                                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($pd->created_at))->diffForHumans() }}
                            </td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a class='delete' href="admin/product/delete/{{$pd->id}}"> Delete</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/product/edit/{{$pd->id}}">Edit</a></td>
                        </tr>
                        <?php $i++ ?>
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
    <script type="text/javascript">
        window.onload = function(){
            $('.delete').click(function(){
                if(window.confirm('Are you sure')){
                    return true;
                }
                return false;
            });
        }
    </script>
@endsection
