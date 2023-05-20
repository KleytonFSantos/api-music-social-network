<?php

namespace App\Http\Resources;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $userProfile = $this->userProfile;
        $songs = Song::where('user_id', $this->id)->get();
        $totalSongs = $songs->count();

        return [
            'user_id' => $this->id,
            'email' => $this->email,
            'songs' => $totalSongs,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'profile_image' => $userProfile?->profile_image,
            'city' => $userProfile?->city,
            'state' => $userProfile?->state,
            'description' => $userProfile?->description
        ];
    }
}
