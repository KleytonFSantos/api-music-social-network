<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Song;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(private readonly User $model)
    {
    }

    public function register(RegisterRequest $request)
    {

        $user = $this->model::Create([
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password'))
        ]);

        $token = $user->createToken('firsttoken')->plainTextToken;

        return response([
            'statusText' => 'success',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {

        $user = $this->model->findUserByEmail($request->validated('email'));

        abort_if(
            !Hash::check($request->validated('password'), $user->password),
            404,
            'The credentials are invalid'
            );

        $token = $user->createToken('firsttoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout Successfully'
        ], 201);
    }

    public function getUser(): UserResource
    {
        $user = User::find(Auth::user()->id);
        return new UserResource($user);
    }
}
