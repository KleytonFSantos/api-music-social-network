<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;

class EditProfileController extends Controller
{
    public function editProfile(EditProfileRequest $request)
    {
        try {
            $user = User::find(auth()->user()->id);

            $user->update([
                'first_name' => $request->validated('first_name') ?? $user->last_name,
                'last_name' => $request->validated('last_name') ?? $user->first_name,
            ]);

            $arrayUserProfile = tap([
                'profile_image' => $request->validated('profile_image') ?? $user?->userProfile?->profile_image,
                'description' => $request->validated('description') ?? $user?->description,
                'city' => $request->validated('city') ?? $user?->city,
                'state' => $request->validated('state') ?? $user?->state,
                'user_id' => $user->id,
            ], function ($data) use ($user) {
                $user->userProfile()->updateOrCreate([], $data);
            });

            return response([
                'message'=>'Updated with success',
                'user_id' => $user->id,
            ], 201);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }
}
