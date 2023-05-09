<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
    * Faz a autenticação do usuário.
    */
    public function login(Request $request)
    {
        // validate chamado para validar os campos email e password no objeto $request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // autenticar o usuário com as credenciais fornecidas
        if (Auth::attempt($credentials)) {
            // nova sessão 
            $request->session()->regenerate();
            // busca o usuário correspondente no banco de dados
            $user = User::where('email', $request->email)->first();
            // armazena os dados do usuário na sessão
            $request->session()->put([
                'name' => $user->name,
                'email' => $user->email,
                'logged_in' => true,
                'level' => null
            ]);
            // registro de log
            $activity = "Logged in";
            $this->insertLog($activity, 2, null);
            // se bem sucedida, rediciona para dashboard
            return redirect()->intended('/dashboard');
        }
        // autenticação falhar, rediciona para login com mensagem de falha 
        return back()->withErrors([
            'email' => 'As credenciais informadas não foram encontradas em nossos registros.',
        ]);
    }
}
