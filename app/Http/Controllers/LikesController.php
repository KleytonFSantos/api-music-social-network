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

    public function store(int $post_id, int $user_id)
    {
        try {
            $likeExists = $this->model->likeExists($post_id, $user_id);
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

            return response([
                'post_id' => $post_id,
                'isLiked' => $likeExists->liked,
                'qtdLikes' => $this->model->qtdLikes($post_id),
                'message' => 'Like resolve successfully'
            ], 201);
        } catch ( \Exception $e ) {
            abort(400, $e->getMessage());
        }
    }
}
