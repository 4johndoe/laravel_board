<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\VerifyMail;
use App\Providers\RouteServiceProvider;
use App\Entity\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
   use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

        Mail::to($user->email)->send(new VerifyMail($user));
        event(new Registered($user));

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified');
        }

        if ($user->status !== User::STATUS_WAIT) {
            return redirect()->route('login')
                ->with('error', 'Your email is already verified.');
        }

        $user->status = User::STATUS_ACTIVE;
        $user->verify_token = null;
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Your email is verified. You can now login.');
    }
}
