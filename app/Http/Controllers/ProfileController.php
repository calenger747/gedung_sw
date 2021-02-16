<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\User;
use App\Gedung;

use Session;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        if (Session::get('role') == '1')
        {
            $id = Session::get('id');
            $user = User::find($id);
            $g = Gedung::all();

            return view('profile.edit', ['user' => $user, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
        
    }

    public function editUser()
    {
        if (Session::get('role') == '2')
        {
            $id = Session::get('id');
            $user = User::find($id);

            $g = Gedung::all();
            return view('profile.edit-user', ['user' => $user, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
        
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->validate($request,[
           'name' => 'required',
           'email' => 'required'
        ]);
     
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password($id, Request $request)
    {
        $this->validate($request,[
           'current_password' => 'required',
           'password' => 'required',
           'password_confirmation' => 'required'
        ]);

        $user = User::find($id);
        if ($user->password == md5($request->current_password)) {
            if ($request->password == $request->password_confirmation) {
                $password = md5($request->password);
                $user = User::find($id);
                $user->password = $password;
                $user->save();

                return back()->withPasswordStatusSuccess(__('Password successfully updated.'));
            } else {
                return back()->withPasswordStatusFail(__('Confirm password not be same'));
            }
        } else {
            return back()->withPasswordStatusFail(__('Current password not be same'));
        }

    }
}
