<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikesController extends Controller
{
    protected $model;

    public function __construct(Like $model)
    {
        $this->model = $model;
    }

    public function store(int $user_id, int $post_id)
    {
        $likeExists = $this->model->likeExists($user_id, $post_id);
        if($likeExists) {
            $likeExists->update([
                'liked' => !$likeExists->liked
            ]);
        } else {
            $like = $this->model::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'liked' => true
            ]);
        }

        return response(['message' => 'Like resolve successfully'], 201);
    }
}
