<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function getList(){
    	$users = User::all();
    	return view('admin.user.list', ['users' => $users]);
    }

    public function getAdd(){
    	return view('admin.user.add');
    }

    public function postAdd(Request $req){
    	$this->validate($req, 
    		[
				'txtUser'   => 'required|max:32|min:2',
				'txtPass'   => 'required|min:3',
				'txtRePass' => 'required|same:txtPass',
				'txtEmail'  => 'required|unique:users,email',
				'rdoLevel'  => 'required'
    		],
    		[
				'txtUser.required'   => 'Please enter user name',
				'txtUser.max'        => 'User name too long (2 - 32 characters)',
				'txtUser.min'        => 'User name too short (2 - 32 characters)',
				'txtPass.required'   => 'Please enter password',
				'txtRePass.required' => 'Please confirm password',
				'txtRePass.same'     => 'Repassword not match',
				'txtEmail.required'  => 'Please enter email',
				'txtEmail.unique'    => 'The email has already exists',
				'rdoLevel.required'  => 'Please choose the level of the user',
    		]
    	);

    	$user = new User;
    	$user->username = $req->txtUser;
    	$user->password = bcrypt($req->txtPass);
    	$user->email  	= $req->txtEmail;
    	$user->level 	= $req->rdoLevel;
    	$user->save();

    	return redirect('admin/user/add')->with(['mess' => 'Done', 'level' => 'success']);
    }

    public function getEdit($id){
    	$user  = User::find($id);
        if(Auth::user()->level == $user->level ){
            return redirect('admin/user/list')->with(['level' => 'danger', 'mess' => 'You can not edit the account that has same level']);
        }

    	return view('admin.user.edit', ['user' => $user]);
    }

    public function postEdit(Request $req, $id){
		$user  = User::find($id);
    	// Validate data
    	$this->validate($req, 
    		[
    			'txtUser' => 'required|max:32|min:2',
    			'rdoLevel' => 'required'
    		],
    		[
    			'txtUser.required' => 'Please enter user name',
    			'txtUser.max' => 'User name too long (2 - 32 characters)',
    			'txtUser.min' => 'User name too short (2 - 32 characters)',
    			'rdoLevel.required' => 'Please choose the level of the user',
    		]
    	);

    	// Check if user want to chage password

    	if( $req->isChangePass ===  'on'){
    		$this->validate($req,
    			[
    				'txtPass' => 'required|min:3',
    				'txtRePass' => 'required|same:txtPass',
    			], 
    			[
    				'txtPass.required' => 'Please enter password',
    				'txtRePass.required' => 'Please confirm password',
    				'txtRePass.same' => 'Repassword not match',
    			]
    		);
    		$user->password = bcrypt($req->txtPass);
    	}
    	// Save to database
    	$user->username = $req->txtUser;
    	$user->level 	= $req->rdoLevel;
    	$user->save();

    	return redirect('admin/user/edit/'.$id)->with(['level' => 'success', 'mess' => 'Done']);
    }

    public function getDelete($id){
    	$user = User::find($id);

        // Không cho phép xóa chính bản thân hoặc xóa người có cũng cấp
        if(Auth::user()->level == $user->level || Auth::user()->id == $id){
            return redirect('admin/user/list')->with(['level' => 'danger', 'mess' => 'You can not delete yourself or delete account that has same level']);
        }

        $user->delete();    
    	return redirect('admin/user/list')->with(['level' => 'success', 'mess' => 'Done']);
    }

    public function getLoginAdmin(){
        return view('admin.login');
    }

    public function postLoginAdmin(Request $req){
        $this->validate($req,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Please enter your email',
                'password.required' => 'Please enter your password'
            ]
        );

        if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){
            return redirect('admin/product/list');
        }else{  
            return redirect('login')->with(['mess' => 'Login fail', 'level' => 'danger']);
        }
    }

    public function getRegisterAdmin(){
        return view('admin.register');
    }

    public function postRegisterAdmin(Request $req){

    }

    public function getLogout(){
        Auth::logout();
        return redirect('login');
    }
}
