<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    public function __invoke(Post $model): AnonymousResourceCollection
    {
        if (Cache::has('posts')) {
            $posts = Cache::get('posts');
        } else {
            $posts = $model->allPosts();

            Cache::put('posts', $posts, 60 * 60);
        }

        return FeedResource::collection($posts);
    }

}
