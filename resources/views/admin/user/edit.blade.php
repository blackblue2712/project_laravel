@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @include('admin.message')
                <form action="admin/user/edit/{{$user->id}}" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="txtUser" placeholder="Please Enter Username" value="{{$user->username}}" />
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="isChangePass" id="isChangePass">
                        <label>Password</label>
                        <input type="password" class="form-control password" disabled="" name="txtPass" placeholder="Please Enter Password" />
                    </div>
                    <div class="form-group">
                        <label>RePassword</label>
                        <input type="password" class="form-control password" disabled="" name="txtRePass" placeholder="Please Enter RePassword" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" readonly class="form-control" name="txtEmail" placeholder="Please Enter Email" value="{{$user->email}}" />
                    </div>

                    <!-- Không cho người dùng sửa quyền của chính mình -->
                    @if(Auth::user()->id != $user->id)
                    <div class="form-group">
                        <label>User Level</label>
                        <label class="radio-inline">
                            @if($user->level == 1)
                                <input name="rdoLevel" value="1" checked="" type="radio">Admin
                            @else
                                <input name="rdoLevel" value="1" type="radio">Admin
                            @endif
                        </label>
                        <label class="radio-inline">
                            @if($user->level == 2)
                                <input name="rdoLevel" value="2" checked="" type="radio">Member
                            @else
                                <input name="rdoLevel" value="2" type="radio">Member
                            @endif
                        </label>
                    </div>
                    @endif
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default">User Edit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
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
            $('#isChangePass').click(function(){
                if( !$(this).is(':checked') ){
                    $('.password').attr('disabled', 'disabled');
                }else{
                    $('.password').removeAttr('disabled');
                }
            });
        }
    </script>
@endsection