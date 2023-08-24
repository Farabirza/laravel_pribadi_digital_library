<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::LOGIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            "first_name" => 'required|max:12',
            "last_name" => 'required|max:12',
            "gender" => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $email = $data['email'];
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);
        
        $user_id = User::where('email',$email)->first()->id;
        $profile = Profile::create([
            "first_name" => $first_name,
            "last_name" => $last_name,
            "gender" => $data['gender'],
            "user_id" => $user_id
        ]);
        if($data['gender'] == 'female'){
            Profile::where('user_id', $user_id)->update(["image" => 'female.png' ]);
        } else { 
            Profile::where('user_id', $user_id)->update(["image" => 'male.png' ]);
        }

        return redirect('/login')->with('success', 'Successfully registered!');
    }
}
