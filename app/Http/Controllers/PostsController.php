<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class PostsController extends Controller
{
    protected Post $model;

    public function __construct(
        Post $model
    )
    {
        $this->model = $model;
    }

    public function index(): ResourceCollection
    {
        $posts = $this->model->findPostsByUserId();

        return PostResource::collection($posts);
    }

    public function postById(int $post): Response
    {
        $post = $this->model->findPostById($post);

        if ($post->isEmpty()) {
            return response('Post not found', ResponseStatus::HTTP_NOT_FOUND);
        }
        return response(['data' => $post]);
    }

    public function store(CreatePostRequest $request): Response
    {
        try {
            $post = $this->model->createPost($request->validated());

            return response(
                [
                    'message' => 'Post created successfully',
                    'post' => $post
                ], 201
            );
        } catch( \Exception $e ) {
            abort(400, $e->getMessage());
        }
    }

    public function update(UpdatePostRequest $request, Post $post): Response
    {
        try {
            $post->update($request->validated());

            return response(
                [
                    'message' => 'Post updated successfully',
                    'post' => $post
                ], 200
            );
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Post $post): Response
    {
        try {
            $post->delete();
            return response( '', ResponseStatus::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
