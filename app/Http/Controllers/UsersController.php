<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gedung;
use Session;

class UsersController extends Controller
{
	public function __construct()
    {
        // $this->middleware('auth');
    	// $this->middleware('role:User');
    }

    public function index()
    {
        if (Session::get('role') == '2')
        {
        	$id = Session::get('id');
            $user = User::find($id);
            $g = Gedung::all();

            return view('user.index', ['user' => $user, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }
    
}
