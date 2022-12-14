<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $authUser = auth()->user()->id;
        $userLiked = $this->like->where('user_id', $authUser)->where('liked', 1)->first();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'likes' => $this->like->count(),
            'user_liked' => $userLiked ? true : false,
            'profile_image' => $this->profile_image,
            'data' => Carbon::parse($this->created_at)->locale('pt-BR')->diffForHumans(Carbon::now()),
        ];
    }
}
