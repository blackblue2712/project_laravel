@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>List</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @include('admin.message')
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Email</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach($users as $user)
                        <tr class="odd gradeX" align="center">
                            <td>{{$i}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{ ($user->level == 1) ? 'Admin' : 'Member' }}</td>
                            <td>{{$user->email}}</td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a class="delete" href="admin/user/delete/{{$user->id}}"> Delete</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/user/edit/{{$user->id}}">Edit</a></td>
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
<!-- /#page-wrapper -->
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