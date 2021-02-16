<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Gedung;
use DB;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        if (Session::get('role') == '1')
        {
            $id = Session::get('id');
            $user = $model->find($id);
            $g = Gedung::all();

            return view('users.index', ['users' => $model->paginate(5)], ['user' => $user, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }


    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $data)
    {
        $this->validate($data,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

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

                return back()->withStatus(__('User successfully created.'));
            } else {
                return back()->withStatusFail(__('Confirm password not be same'));
            }
        } else {
            return back()->withStatusFail(__('Email already registered'));
        }
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $data)
    {
        $this->validate($data,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        if ($data->password == $data->password_confirmation) {
            $user = User::find($id);
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = $data->password;
            $user->password = md5($data->password);
            $user->save();
            return redirect('/admin/users')->withStatus(__('User successfully updated.'));
        } else {
            return back()->withStatusFail(__('Confirm password not be same'));
        }
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, User  $user)
    {
        $users = $user->find($id);
        $users->delete();
     
        return back()->withStatus(__('User successfully deleted.'));
    }
}
