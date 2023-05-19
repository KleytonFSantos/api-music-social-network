<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeedController extends Controller
{
    public function __invoke(Post $model): AnonymousResourceCollection
    {
        $posts = $model->allPosts();

        return FeedResource::collection($posts);
    }

}
