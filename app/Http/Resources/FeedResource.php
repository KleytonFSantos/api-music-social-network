<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FeedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $authUser = auth()->user()->id;
        $userLiked = $this->like->where('user_id', $authUser)->where('liked', 1)->first();
        $date = Carbon::parse($this->created_at)->locale('pt-BR')->diffForHumans(Carbon::now());

        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'likes' => $this->like->count(),
            'user_liked' => !!$userLiked,
            'profile_image' => $this->profile_image,
            'data' => $date,
        ];
    }
}
