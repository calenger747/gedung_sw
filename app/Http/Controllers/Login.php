<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use App\User;
use App\Role;
use Auth;
use Hash;
use Session;

class Login extends Controller
{
    public function index(){
		if (Session::get('role') == '1')
        {
            return redirect('/admin');  

     	} else if (Session::get('role') == '2') {
     		return redirect('/user');

        } else {
        	return view('welcome');
        }
        return view('welcome');
    }
    
	public function getLogin(){
		if (Session::get('role') == '1')
        {
            return redirect('/admin');  

     	} else if (Session::get('role') == '2') {
     		return redirect('/user');

        } else {
        	return view('auth.login');
        }
        return view('auth.login');
    }
    public function postLogin(){

    	$email = $_POST['email'];
		$password = md5($_POST['password']);

		$users = DB::table('users')
         ->where('email', '=', $email)
         ->where('password', '=', $password)
         ->get();
         $count = count($users);
         if ($count > 0) {
         	if ($users[0]->id_role == '1') {
         		//KE HALAMAN ADMIN
         		Session::put('id', $users[0]->id);
         		Session::put('email', $users[0]->email);
         		Session::put('nama', $users[0]->name);
         		Session::put('role', $users[0]->id_role);
         		Session::put('login', 'Selamat anda berhasil login');
				return Redirect("/admin");
         	}else if($users[0]->id_role == '2'){
         		//KE HALAMAN USER
         		Session::put('id', $users[0]->id);
         		Session::put('email', $users[0]->email);
         		Session::put('nama', $users[0]->name);
         		Session::put('role', $users[0]->id_role);
         		Session::put('login', 'Selamat anda berhasil login');
				return Redirect("/user");
         	}else{
         		return redirect('/logout');
         	}
         }else{
         	return redirect("/login");
         }
    }   
    public function getRegister(){
    	if (Session::get('role') == '1')
        {
            return view('dashboard');  

     	} else if (Session::get('role') == '2') {
     		return view('user.index');

        }
        return view('auth.register');
    }
    public function postRegister(Request $data){
        $users = DB::table('users')
         ->where('email', '=', $data->email)
         ->get();
         $count = count($users);
         if ($count < 1) {
            if ($data->password == $data->password_confirmation) {
                $password = md5($data->password);
                $user = new User();
        
                $user->name = $data->name;
                $user->email = $data->email;
                $user->password = $data->password;
                $user->password = md5($data->password);
                $user->save();

                return redirect('/Register')->withStatus(__('Registration successful'));
            } else {
                return back()->withStatusFail(__('Confirm password not be same'));
            }
        } else {
            return back()->withStatusFail(__('Email already registered'));
        }
    }
    public function getLogout(){
    	session()->forget('id');
    	session()->forget('email');
    	session()->forget('nama');
    	session()->forget('role');
    	session()->forget('login');
        Session::flush();
        return redirect('/home');
    }    
}
