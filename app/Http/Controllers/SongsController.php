<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use File;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Http\Services\UploadSongsService;
use App\Models\User;
use Illuminate\Http\Response;

class SongsController extends Controller
{

    public function __construct(
        protected Song $model
    ) {
    }

    public function index(int $user_id): Response
    {
        $user = User::find($user_id);

        return response([
            'artist_id' => $user->id,
            'artist_name' => $user->first_name . ' ' . $user->last_name,
            'songs' => $user->song ?? []
        ], 200);
    }

    public function store(SongRequest $request, UploadSongsService $service): Response
    {
        try {
            if ($request->hasFile('song')) {
                $file = $request->validated('song');
                $service->uploadSongs($file);
            }

            $song = $this->model::create($request->validated());
            return response(['message' => 'Uploaded with success'], 201);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function destroy($user_id, $song)
    {
        try {
            $songs_by_user = $this->model->findSongById($user_id, $song);
            File::delete(public_path('storage/songs/' . $user_id . '/' . $songs_by_user->namefile));
            $songs_by_user->delete();

            return response(['message' => 'Song deleted successfully'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e], 400);
        }
    }
}
