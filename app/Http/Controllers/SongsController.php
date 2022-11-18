<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Songs;

class SongsController extends Controller
{
    protected $model;

    public function __construct(
        Songs $model
    )
    {
        $this->model = $model;
    }

    /**
     *  Store Songs Function
     *@param  \Illuminate\Http\Request  $request
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|min:3|required',
            'song' => 'file'
        ]);


        try {
            if( $request->hasFile('song')){
                $file = $request->file('song');
                $original_name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = $original_name . $extension;
                $path = $file->storeAs('songs', $filename);
            }

            $song = $this->model::create([
                'title' => $request->title,
                'namefile' => $filename,
            ]);

            return response(['message'=>'Uploaded with success'], 201);
        } catch (\Exception $e) {
            abort(500, $e);
        }

    }
}
