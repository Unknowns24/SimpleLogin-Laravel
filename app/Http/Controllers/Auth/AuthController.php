<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\VerificationMailTrait;
use UNK\Praesidium\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;

class AuthController extends Controller
{
    use VerificationMailTrait; 

    protected $redirectTo = '/';

    public function loginForm() 
    {
        if(Auth::user()) {
            return redirect($this->redirectTo);
        }
        
        return view('auth.login');
    }

    public function registerForm()
    {
        if(Auth::user()) {
            return redirect($this->redirectTo);
        }

        return view('auth.register');
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

        if (Auth::attempt($credentials, $rememberMe))
        {
            return redirect($this->redirectTo);
        }
        else
        {
            return redirect()->back()->withErrors(['login' => 'Los datos ingresados son incorrectos o no tienes permiso para loguearte!']);
        }
    }

    public function register(Request $req)
    {
        if(Auth::user()) {
            return redirect($this->redirectTo);
        }

        $req->validate([
            'username' => 'required|max:100',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:32|max:32|confirmed',
        ]);
        
        $user = new User();

        $user->name = request('username');
        $user->email = request('email');
        $user->password = request('password');
        
        $user->save();

        //Busca el rol de usuario
        $roleUser = Role::where('slug', 'user')->first();

        // Asigna Rol de Usuario
        $user->roles()->sync($roleUser->id);
        
        $credentials = $req->only('email', 'password');

        $this->SendMail(request('email'));

        Auth::attempt($credentials);

        return redirect($this->redirectTo);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    
    public function verifyMail($id, $code)
    {
        if (!is_numeric($id))
        {
            return abort('403');
        }
        
        $userData = DB::select("SELECT `created_at`, `email`, `email_verified_at` FROM `users` WHERE `id` = ?", [$id]);
        
        if($userData[0]->email_verified_at != NULL)
        {
            return redirect(url('/'));
        }

        $token = md5($userData[0]->email . $userData[0]->created_at);

        if ($token == $code) 
        {
            $user = User::findOrFail($id);
            $user->email_verified_at = new Carbon();
            $user->update();
        }

        return view('auth.verification', ['validated' => true])->with(['success' => 'Tu correo se ha verificado satisfactoriamente!']);
    }

    public function verification()
    {
        if (Auth::check() == false)
        {
            return abort('403');
        }
        
        if ($this->emailValidated(Auth::user()->id) == false) 
        {
            return view('auth.verification');
        }
        
        return redirect(url('/'));
    }

    public function ResendMail()
    {
        if (Auth::check() == false)
        {
            return abort('403');
        } 

        if ($this->emailValidated(Auth::user()->id) == true) 
        {
            return redirect(url('/'));
        }

        try
        {
            if ($this->SendMail(User::findOrFail(Auth::user()->id)->email) == true)
            {
                return back()->with('success', 'Se le ha reenviado el correo electronico');
            }
            else
            {
                return back()->with('error', 'Se produjo un error al intentar reenviarle el correo electronico, intente mas tarde!');
            }
        }
        catch(Exception $e)
        {
            return back()->with('error', "Se produjo un error al intentar reenviarle el correo electronico, intente mas tarde!\n\nError: $e");
        }
    }
}
