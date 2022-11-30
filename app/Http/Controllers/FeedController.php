<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FeedResource;
use App\Models\Model;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;

class FeedController extends Controller
{
    private $model;
    public function __construct(
        Post $model
    )
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\FeedResource
     */
    public function index()
    {
        $posts = $this->model->allPosts();

        return FeedResource::collection($posts);

    }

}
