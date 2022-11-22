<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostsController extends Controller
{
    protected $model;

    public function __construct(
        Post $model
    )
    {
        $this->model = $model;
    }

    /**
     *  Index Posts Function
     *
     * @param int $user_id
     *
     * @return \Illuminate\Http\Response
    */
    public function index($user_id)
    {
        $posts = $this->model::where('user_id', $user_id)->get();

        return PostResource::collection($posts);
    }

    /**
     * Get Posts By $post_id Function
     *
     * @param int $user_id
     * @param int $post_id
     *
     * @return \Illuminate\Http\Response
    */
    public function postById($user_id, $post_id)
    {
        $post = $this->model::where('user_id', $user_id)->where('id', $post_id)->first();

        return response(['data' => $post]);
    }

     /**
     *  Store Posts Function
     *
     * @param int $user_id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
    */

     /**
     *  Store Posts Function
     *
     * @param int $user_id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request, $user_id)
    {
        try {
            $request->validate([
                'title' => 'required|min:3',
                'image' => 'required',
                'description' => 'required',
            ]);

            $video = $this->model::create([
                'title' => $request->title,
                'image' => $request->image,
                'description' => $request->description,
                'user_id' => $user_id
            ]);

            return response(['message' => 'Post created successfully'], 201);
        } catch( \Exception $e ) {
            abort(400, $e->getMessage());
        }
    }

      /**
     *  Destroy Posts Function
     *
     * @param int $user_id
     * @param int $post
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy( $user_id, $post )
    {
        try {
            $posts_by_user = $this->model::where('user_id', $user_id)->where('id', $post)->first();
            $posts_by_user->delete();

            return response(['message' => 'Post deleted successfully'], 200);
        } catch (\Exception $e) {
          return response(['message' => $e], 400);
        }
    }
}
