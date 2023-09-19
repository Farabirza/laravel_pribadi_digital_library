<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Authority;
use App\Http\Requests\StoreUserRequest;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use File;
use Validator;
use Response;
use DB;

class UsersController extends Controller
{
    public function __construct() {
        $this->metaTags = [
            'title' => 'Digital Library',
            'description' => 'Unlock the world of knowledge!',
        ];
    }
    public function validateError()
    {
        if(isset($validator) && $validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }
    }
    public function google_login() {
        return Socialite::driver('google')->redirect();
    }
    public function google_callback() {
        try {
            $google = Socialite::driver('google')->user();
            // dd($google);
            $user = User::where('google_id', $google->id)->first();
            $email = explode('@', $google->email);
            if($email[1] != 'pribadidepok.sch.id') {
                return redirect('/book')->with('error', "Please only use the school provided email!");
            }
            if($user) {
                Auth::login($user);
                return redirect()->intended('/');
            } else {
                $user_by_email = User::where('email', $google->email)->first();
                if($user_by_email) {
                    Auth::login($user_by_email);
                    return redirect()->intended('/');
                }

                $get_authority = ($email[0] == 'admin') ? 'superadmin' : 'user';
                $authority = Authority::where('name', $get_authority)->first();
                if(!$authority) {
                    $create_authority = Authority::create(['name' => $get_authority]);
                    $authority = $create_authority;
                }
                
                $create_user = User::create([
                    'email' => $google->email,
                    'google_id' => $google->id,
                    'password' => bcrypt($google->email),
                    'email_verified_at' => date('Y-m-d H:i:s', time()),
                    'authority_id' => $authority->id,
                ]);
                Auth::login($create_user);
                return redirect()->intended('/');

                return view('user.create_username', [
                    'user' => $google,
                    'header_title' => '<i class="bx bx-user-plus me-3"></i><span>Registration</span>',
                    'page_title' => "Digital Library | Registration"
                ]);
            }
        } catch (\Throwable $th) {
            return redirect('/?info=Authentication failed');
        }
    }
    public function google_register(Request $request) {
        $create = User::create([
            'email' => $request->google_email,
            'google_id' => $request->google_id,
            'password' => bcrypt($request->google_email),
            'email_verified_at' => date('Y-m-d H:i:s', time()),
        ]);
        Auth::login($create);
        return redirect()->intended('/');
    }
    public function register()
    {
        return view('auth.register',[
            //
        ]);
    }
    public function store(StoreUserRequest $request, User $user) {
        $this->validateError();
        $email_exist = User::where('email', $request->email)->first();
        if($email_exist) {
            return response()->json([
                'message' => 'This email is already in use',
            ], 400);
        }
        $password = Hash::make($request->password);

        $user = User::create([
            "email" => $request->email,
            "password" => $password,
        ]);
        $user->email = explode('@', $user->email)[0];
        $user->key = $request->password;
        return response()->json([
            'message' => 'Registered successfully!',
            'user' => $user,
        ], 200);
        
    }
    public function login()
    {
        return view('auth.login',[ 'page_title' => 'Login Page' ]);
    }
    public function authenticate(Request $request)
    {
        $email = $request['email'].'@pribadidepok.sch.id';
        $remember = ($request['remember'] == 'true') ? true : false;
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if(Auth::attempt([
                'email' => $email, 'password' => $request['password']
            ], $remember)) {
                $request->session()->regenerate();
                return redirect()->intended('/book');
            }
        }
        return back()->with('error', 'Your email or password is incorrect!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function update_password(Request $request){
        $user_id = Auth::user()->id;
        $password = $request['password'];
        $password_confirmation = $request['password_confirmation'];
        if($password != $password_confirmation){ back()->with("error", "Password confirmation doesn't match!"); }

        $validateData = $request->validate([ "password" => 'required|min:6' ]);
        $password = Hash::make($request['password']);
        $password_update = User::where('id',$user_id)->update(["password" => $password]);
        return redirect('/profile')->with('success', 'Password updated!');
    }
    public function confirmation()
    {
        if(Auth::user()->confirmation == 1) {
            return redirect('/book')->with('info', 'Your account is already confirmed');
        }
        return view('auth.confirmation', [
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Confirmation',
        ]);
    }
    public function confirm_user($user_id)
    {
        if(Auth::user()->profile->role == 'student') {
            return back()->with('error', 'Access denied!');
        }
        $user = User::find($user_id);
        $user->update(['confirmation' => 1]);
        return back()->with('success', 'User confirmed');
    }
    public function activity()
    {
        return view('user.activity', [
            'dashboard_header' => '<i class="bx bx-time-five me-3"></i><span>User activity</span>',
            'metaTags' => $this->metaTags,
            'page_title' => 'Digital Library | Activity',
        ]);
    }
    public function show(User $user)
    {
        if(!$user->profile) {
            return back()->with('error', 'This user is not verified yet');
        }
        return view('user.show', [
            'user' => $user,
        ]);
    }
    public function action(Request $request)
    {
        switch ($request->action) {
            case 'confirmation':
                if($request->key != '40620b4f-cc40-402a-8b7d-b6e48f736031') {
                    return response()->json([
                        'message' => "Confirmation key doesn't match!"
                    ], 400);
                }
                $user = User::find(Auth::user()->id)->update(['confirmation' => 1]);
                return response()->json([
                    'message' => "User confirmed"
                ], 200);
            break;
            case 'update_password':
                $this->action_isUser();
                $user_id = ($request->user_id) ? $request->user_id : Auth::user()->id;
                $user = User::find($user_id); $messages = []; $error = false;
                $password = $request->password; $password_confirmation = $request->password_confirmation;
                if($password != $password_confirmation) {
                    $error = true;
                    $messages[] = "password confirmation doesnt't match";
                }
                if(strlen($password) < 6) {
                    $error = true;
                    $messages[] = "must consist of at least 6 characters";
                }
                if($error == false) {
                    $user->update([ 'password' => Hash::make($request->password), ]);
                    $messages[] = "password updated";
                }
                return response()->json([
                    'error' => $error,
                    'message' => $messages,
                ], 200);
            break;
            case 'update_picture':
                $this->action_isUser();
                $user_id = ($request->user_id) ? $request->user_id : Auth::user()->id;
                $user = User::find($user_id);
                $old_picture = ($user->picture) ? $user->picture : null;
        
                // processing image
                $img_parts = explode(";base64,", $request->picture);
                $img_type_aux = explode("image/", $img_parts[0]);
                $img_type = $img_type_aux[1];
                $img_base64 = base64_decode($img_parts[1]);
                $email = explode('@', $user->email);
                $img_name = 'user-'.$email[0].'-'.time().'.'.$img_type;
                $path = public_path('img/profiles/'.$img_name);
                file_put_contents($path, $img_base64);
         
                // update profile
                $update_picture = $user->update(['picture' => $img_name]);

                // unlink
                if($old_picture != null) {
                    if(File::exists($path)) {
                        $unlink = unlink(public_path('img/profiles/'.$old_picture));
                    }
                }

                return response()->json([
                    'message' => "Profile picture updated",
                    'picture_name' => $img_name,
                ], 200);
            break;
        }
    }
    public function action_isUser() 
    {
        if(isset($request->user_id) && Auth::user()->authority->name == 'user') {
            return response()->json([ 'message' => "Action denied" ], 403);
        }
    }
}
