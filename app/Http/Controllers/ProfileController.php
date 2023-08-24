<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use File;
use Validator;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function index()
    {
        return view('profile.index', [
            'dashboard_header' => '<i class="bx bxs-user me-3"></i><span>Profile</span>',
            'page_title' => "Digital Library | Profile",
            'user' => Auth::user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'full_name' => 'required',
        ];
    }
    public function store(ProfileStoreRequest $request)
    {
        $this->validateError();
        if($request->role == 'student' && $request->year_join == null) {
            $errors = (object)[];
            $errors->year_join = 'required';
            return response()->json([
                'errors' => $errors,
            ], 400);
        }
        $create = new ProfileResource(Profile::create($request->validated()));
        return response()->json([
            'message' => 'User profile created',
            'new' => true,
            'profile_id' => $create->id,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        return response()->json([
            'data' => $user->profile,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $this->validateError();
        if($request->role == 'student' && $request->year_join == null) {
            $errors = (object)[];
            $errors->year_join = 'required';
            return response()->json([
                'errors' => $errors,
            ], 400);
        }
        new ProfileResource(tap($profile)->update($request->validated()));
        if($request->role != 'student') { tap($profile)->update(['grade' => '', 'year_join' => '']); }
        return response()->json([
            'message' => 'Profile updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        return response()->json([
            'message' => "User's profile cannot be deleted"
        ], 400);
    }
    public function action(Request $request)
    {
        switch ($request->action) {
            case 'update_cover':
                $this->validate($request, [
                    'user_id' => 'required',
                    'cover_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ]);
                $user = User::find($request->user_id);
                $old_image = ($user->profile->cover_image) ? $user->profile->cover_image : null;
                $image_name = 'cover-'.$user->username.'-'.time().'.'.$request->file('cover_image')->getClientOriginalExtension();
                $request->file('cover_image')->move('img/covers', $image_name);
                if($old_image != null) {
                    if(File::exists(public_path('img/covers/'.$old_image))) { $unlink = unlink(public_path('img/covers/'.$old_image)); }
                }
                $update = Profile::where('user_id', $user->id)->update([
                    'cover_image' => $image_name,
                ]);
                return response()->json([
                    'message' => 'Cover image updated'
                ], 200);
            break;
        }
    }
}
