<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoRequest;
use Illuminate\Http\Request;
use App\Models\Video;
use Symfony\Component\HttpFoundation\Response;

class VideosController extends Controller
{
    public function __construct(
        private Video $model
    ) {
    }

    public function index($user_id): Response
    {
        $videos = $this->model::where('user_id', $user_id)->get();

        return response([
            'videos' => $videos,
            'user_id' => $user_id
        ]);
    }


    public function store(CreateVideoRequest $request, int $user_id): Response
    {
        try {
            $video = $this->model::create($request->validated());

            return response(['message' => 'Video created successfully'], 201);
        } catch( \Exception $e ) {
            abort(400, $e->getMessage());
        }
    }

    public function destroy(int $user_id, Video $video): Response
    {
        try {
            $video->delete();

            return response(['message' => 'Video deleted successfully'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e], 400);
        }
    }
}
