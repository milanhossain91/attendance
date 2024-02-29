<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Auth;
use Redirect;
use Hash;

class LoginController extends Controller
{
    public function pageIndex()
    {
        return view('frontend/masterLogin');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);
   
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']]))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return Redirect::back()->with('danger','Oppes! You have entered invalid credentials');;
        }
    }
    
    public function password()
    {
        $data['title'] = 'Change Password';
        return view('frontend/user/password', $data);
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed'
        ]);
        $user = UserModel::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('/');
    }
}
