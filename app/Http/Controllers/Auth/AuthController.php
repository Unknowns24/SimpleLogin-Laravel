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
            return redirect(url($this->redirectTo));
        }
        
        return view('auth.login');
    }

    public function registerForm()
    {
        if(Auth::user()) {
            return redirect(url($this->redirectTo));
        }

        return view('auth.register');
    }

    public function forgetPassForm()
    {
        if(Auth::user()) {
            return redirect(url($this->redirectTo));
        }

        return view('auth.forgotpassword');
    }

    public function login(Request $req)
    {
        $rememberMe = false;

        $req->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:32|max:32',
        ]);
        
        $userEmail = $req->email;
        
        $req->merge(['email' => strtolower($userEmail)]); // Se pone en minusculas para una posterior compatibilidad

        if (Request('remember') )
        {
            $rememberMe = true;
        }

        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials, $rememberMe))
        {
            return redirect(url($this->redirectTo));
        }
        else
        {
            return redirect()->back()->withErrors(['login' => 'Los datos ingresados son incorrectos o no tienes permiso para loguearte!']);
        }
    }

    public function register(Request $req)
    {
        if(Auth::user()) {
            return redirect(url($this->redirectTo));
        }

        $req->validate([
            'username' => 'required|max:100',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:32|max:32|confirmed',
        ]);

        $userEmail = $req->email;
        
        $req->merge(['email' => strtolower($userEmail)]); // Se pone en minusculas para una posterior compatibilidad

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

        $this->SendVerificationMail(request('email'));

        Auth::attempt($credentials);

        return redirect(url($this->redirectTo));
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

        if (empty($userData))
        {
            return abort('403');
        }
        
        if($userData[0]->email_verified_at != NULL)
        {
            return redirect(url($this->redirectTo));
        }

        $token = md5($userData[0]->email . $userData[0]->created_at);

        if ($token == $code) 
        {
            $user = User::findOrFail($id);
            $user->email_verified_at = new Carbon();
            $user->update();
            return view('auth.verification', ['validated' => true])->with(['success' => 'Tu correo se ha verificado satisfactoriamente!']);
        }

        return abort('403');
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
        
        return redirect(url($this->redirectTo));
    }

    public function ResendMail()
    {
        if (Auth::check() == false)
        {
            return abort('403');
        } 

        if ($this->emailValidated(Auth::user()->id) == true) 
        {
            return redirect(url($this->redirectTo));
        }

        try
        {
            if ($this->SendVerificationMail(User::findOrFail(Auth::user()->id)->email) == true)
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
            return back()->with('error', "Se produjo un error al intentar reenviarle el correo electronico, intente mas tarde!");
        }
    }
    
    public function sendResetPasswordEmail()
    {
        if (Auth::check() == true)
        {
            return redirect(url($this->redirectTo));
        } 

        request()->validate([
            'email' => 'required|email:rfc,dns',
        ]);

        $userEmail = request()->email;
        
        request()->merge(['email' => strtolower($userEmail)]); // Se pone en minusculas para una posterior compatibilidad

        try
        {
            if ($this->SendResetPasswordMail(request()->email) == true)
            {
                return back()->with('success', 'Revise su correo electronico');
            }
            else
            {
                return back()->with('error', 'Se produjo un error al intentar reenviarle el correo electronico, intente mas tarde!');
            }
        }
        catch(Exception $e)
        {
            return back()->with('error', "Se produjo un error al intentar reenviarle el correo electronico, intente mas tarde!");
        }
    }

    public function verifyPasswordReset($id, $code)
    {
        if (!is_numeric($id))
        {
            return abort('403');
        }
        
        $userData = DB::select("SELECT `name`, `created_at`, `email`, `requested_at` FROM `users` WHERE `id` = ?", [$id]);

        if (empty($userData))
        {
            return abort('403');
        }
        
        if ($userData[0]->requested_at == NULL || $userData[0]->requested_at <= Carbon::createFromTimestamp(time() - 600)->toDateTimeString())
        {
            return view('auth.resetpassword', ['userToken' => NULL, 'id' => $id]);
        }
        
        $token = md5(strtolower($userData[0]->name) . strtolower($userData[0]->email) . $userData[0]->created_at);

        if ($token == $code) 
        {
            return view('auth.resetpassword', ['userToken' => $token, 'id' => $id]);
        }

        return view('auth.resetpassword', ['userToken' => NULL, 'id' => $id]);
    }

    public function ResetPassword($id, Request $req)
    {
        if (Auth::check())
        {
            return abort('404');
        }

        $req->validate([
            'password' => 'min:32|max:32|confirmed'
        ]);

        $user = User::findOrFail($id);

        $user->password = $req->password;
        
        $user->update();

        return redirect(route('login'))->with('success', '¡La contraseña se ha actualizado correctamente!');
    }
}
