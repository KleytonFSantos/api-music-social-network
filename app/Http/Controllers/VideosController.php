<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideosController extends Controller
{
    private $model;

    public function __construct(
        Video $model
    )
    {
        $this->model = $model;
    }

    /**
     *  Get Videos Function
     * @param int $user_id
     * @return \Illuminate\Http\Response
    */
    public function index($user_id)
    {
        $videos = $this->model::where('user_id', $user_id)->get();

        return response([
            'videos' => $videos,
            'user_id' => $user_id
        ]);
    }

    /**
     *  Store Videos Function
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
                'video' => 'required|min:3',
            ]);

            $video = $this->model::create([
                'title' => $request->title,
                'path' => $request->video,
                'user_id' => $user_id
            ]);

            return response(['message' => 'Video created successfully'], 201);
        } catch( \Exception $e ) {
            abort(400, $e->getMessage());
        }
    }

    /**
     *  Destroy Videos Function
     *
     * @param int $user_id
     * @param int $video
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy( $user_id, $video )
    {
        try {
            $videos_by_user = $this->model::where('user_id', $user_id)->where('id', $video)->first();
            $videos_by_user->delete();

            return response(['message' => 'Video deleted successfully'], 200);
        } catch (\Exception $e) {
          return response(['message' => $e], 400);
        }
    }
}
