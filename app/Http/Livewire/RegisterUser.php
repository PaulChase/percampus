<?php

namespace App\Http\Livewire;

use App\Models\Campus;
use App\Models\Referral;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterUser extends Component
{
    public $univerisities;
    public $name;
    public $phone;
    public $email;
    public $password;
    public $password_confirm;
    public $campus_id;



    public function mount()
    {
        $this->univerisities = Campus::orderBy('name')
            ->where('type', Campus::UNIVERSITY)
            ->get();
    }

    public function createUser()
    {
        $data =   $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|numeric|digits_between:10,11',
            'campus_id' => 'required|integer|exists:campuses,id'
        ]);

        if ($this->password !== $this->password_confirm) {
            return  $this->addError('password_mismatch', 'the password is not the same with the confirm password');
        }

        $data['password'] = Hash::make($this->password);

        $user =   User::create($data);

        event(new Registered($user));


        $user->notify(new WelcomeEmailNotification());

        if (Cookie::has('refererID')) {
            $referral = new Referral();
            $referral->referee = $user->id;
            $referral->referer = Cookie::get('refererID');
            $referral->save();
        }


        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.register-user');
    }
}
