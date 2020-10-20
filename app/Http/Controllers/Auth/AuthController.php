<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $redirectTo = '/';

    public function loginForm() 
    {
        if(Auth::user()) {
            return redirect($this->redirectTo);
        }
        
        return view('Auth.login');
    }

    public function registerForm()
    {
        if(Auth::user()) {
            return redirect($this->redirectTo);
        }

        return view('Auth.register');
    }

    public function login(Request $req)
    {
        $rememberMe = false;

        $req->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:32|max:32',
        ]);
        
        if (Request('remember') )
        {
            $rememberMe = true;
        }

        $credentials = $req->only('email', 'password');

        Auth::attempt($credentials, $rememberMe);

        return redirect($this->redirectTo);
    }

    public function register(Request $req)
    {
        if(Auth::user()) {
            return redirect($this->redirectTo);
        }

        $req->validate([
            'username' => 'required|max:100|unique:users,name',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:32|max:32|confirmed',
        ]);
        
        $user = new User();

        $user->name = request('username');
        $user->email = request('email');
        $user->password = request('password');
        
        $user->save();
        
        $credentials = $req->only('email', 'password');

        Auth::attempt($credentials);

        return redirect($this->redirectTo);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
