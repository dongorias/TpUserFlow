<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewPassword;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;


class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        return view('auth.register');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard/user/index')
                ->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")->withError('Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        //$data = $request->all();
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //$user = $this->create($data);

        Auth::login($user);

        return redirect("dashboard/user/index")->withSuccess('Great! You have Successfully loggedin');
    }

    /**
     * Write code on Method
     *
     * @return Factory|\Illuminate\Contracts\View\View|Application()
     */
    public function dashboard(): Factory|\Illuminate\Contracts\View\View|Application
    {
        if(Auth::check()){
            return view('users.list');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(Request $request): RedirectResponse
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect('login');
    }


    public function send_new_password(Request $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return redirect()->route("password.forgot")->withError('User not exist');
        }

        $new_password = Str::random(10);
        $user->password = Hash::make($new_password);
        $user->save();

        try {
            Mail::to($user->email)->send(new NewPassword($new_password, $user));
        } catch (\Exception $exception) {
            Log::warning('send_new_password: ' . $exception->getMessage());
        }

        return redirect()->route("password.forgot")->withSuccess('Votre mot de passe a été réinitialisé avec succès. Un email contenant votre nouveau mot de passe vous a été envoyé.');

    }
       public function password_forgot()
    {

        return view('auth.forgot-password');
    }



}
