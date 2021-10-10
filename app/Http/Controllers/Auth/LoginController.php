<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;



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

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function getGoogleUser()
    {
        $user = Socialite::driver('google')->user();

        // dd($user);

        $finduser = User::where('googleID', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser);

            return redirect()->route('home');

        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            // $newUser->phone = $user->phone;
            $newUser->googleID = $user->id;
            $newUser->password = Hash::make('d8u6m6m1y');
            $newUser->save();

           Auth::login($newUser);

            return redirect()->route('getuserinfo');
        }
    }

    


}
