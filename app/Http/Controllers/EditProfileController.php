<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;

class EditProfileController extends Controller
{
    public function editProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'min:3',
            'last_name' => 'min:3',
            'avatar' => 'image|size:2048'
        ]);
        $namefile = null;
        if(isset($request->avatar)){
            $fileStorage = $request->file('avatar')->store('avatar', 'public');
            $namefile = str_replace('avatar/', '', $fileStorage);
        }

        $user = User::find(auth()->user()->id);
        $user->update([
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'avatar' => $namefile ?? $user->avatar,
           'description' => $request->description ?? $user->description,
           'city' => $request->city ?? $user->city,
           'state' => $request->state ?? $user->state,
        ]);

        return response(['message'=>'Updated with success'], 201);
    }
}
