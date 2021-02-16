<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Gedung;
use App\Lantai;
use App\Rak;
use App\Perangkat;
use App\Port;
use Session;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('role:Admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Session::get('role') == '1')
        {
            $id = Session::get('id');
            $user = User::find($id);
            $g = Gedung::all();

            return view('dashboard', ['user' => $user, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }
}
