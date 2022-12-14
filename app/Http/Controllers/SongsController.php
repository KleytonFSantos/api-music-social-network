<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Http\Services\UploadSongsService;
use App\Models\User;

class SongsController extends Controller
{
    protected $model;

    public function __construct(
        Song $model
    ) {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $user_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $user_id)
    {
        $songs = [];
        $songs_by_user = $this->model::where('user_id', $user_id)->get();
        $user = User::find($user_id);

        foreach ($songs_by_user as $song) {
            array_push($songs, $song);
        }

        return response()->json([
            'artist_id' => $user->id,
            'artist_name' => $user->first_name . ' ' . $user->last_name,
            'songs' => $songs
        ], 200);
    }

    /**
     *  Store Songs Function
     *@param  \Illuminate\Http\Request  $request
     *
     *@param  \App\Http\Services\UploadSongsService $service
     */
    public function store(Request $request, UploadSongsService $service)
    {

        try {
            $request->validate([
                'title' => 'string|min:3|required',
                'song' => 'file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            ]);

            if ($request->hasFile('song')) {
                $file = $request->file('song');
                $original_name = $file->getClientOriginalName();
                $service->uploadSongs($file);
            }

            $song = $this->model::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'artist' => $request->artist,
                'cover' => $request->coverImage,
                'namefile' => $original_name,
            ]);
            return response(['message' => 'Uploaded with success'], 201);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    /**
     * Delete a song of the resource.
     *
     * @param int $user_id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $song)
    {
        try {
            $songs_by_user = $this->model::where('user_id', $user_id)->where('id', $song)->first();
            $deleteSong = File::delete(public_path('storage/songs/' . $user_id . '/' . $songs_by_user->namefile));
            $songs_by_user->delete();

            return response(['message' => 'Song deleted successfully'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e], 400);
        }
    }
}
