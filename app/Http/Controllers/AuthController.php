<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Song;
use App\Models\User;

class AuthController extends Controller
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     *  User Register Function
     *@param  \Illuminate\Http\Request  $request
    */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|',
            'last_name' => 'required|string|',
            'email'=>'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed|'
        ]);

        $user = $this->model::Create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('firsttoken')->plainTextToken;

        return response([
            'statusText' => 'success',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     *  User Login Function
     *@param  \Illuminate\Http\Request  $request
    */
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|string|email',
            'password' => 'required|string'
        ]);

        $user = $this->model::where('email', $request->email)->first();

        abort_if(
            ! $user || !Hash::check($request->password, $user->password),
            404,
            'The credentials are invalid'
            );

        $token = $user->createToken('firsttoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     *  User Logout Function
     *
    */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout Successfully'
        ], 201);
    }

    public function getUser()
    {
        $user = auth()->user();
        $userProfile = $user->userProfile;
        $songs = Song::where('user_id', $user->id)->get();
        $totalSongs = $songs->count();
        return [
            'user_id' => $user->id,
            'email' => $user->email,
            'songs' => $totalSongs,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'profile_image' => $userProfile->profile_image,
            'city' => $userProfile->city,
            'state' => $userProfile->state,
            'description' => $userProfile->description
        ];
    }
}
