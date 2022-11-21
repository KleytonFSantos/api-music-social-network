<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;

class EditProfileController extends Controller
{
    public function editProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'min:3',
            'last_name' => 'min:3',
        ]);

        try {

            $user = User::find(auth()->user()->id);

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);

            if ($user->userProfile) {
                $user->userProfile->update([
                   'profile_image' => $request->profile_image ?? $user->userProfile->profile_image,
                   'description' => $request->description ?? $user->description,
                   'city' => $request->city ?? $user->city,
                   'state' => $request->state ?? $user->state,
                ]);
            } else {
                $userProfile = UserProfile::create([
                    'profile_image' => $request->profile_image,
                    'description' => $request->description ?? $user->description,
                    'city' => $request->city ?? $user->city,
                    'state' => $request->state ?? $user->state,
                    'user_id' => $user->id,
                 ]);
            }


            return response([
                'message'=>'Updated with success',
                'user_id' => $user->id,
            ], 201);
        } catch (\Exception $e) {
            abort(400, $e);
        }
    }
}
