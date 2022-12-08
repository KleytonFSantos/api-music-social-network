<?php

namespace App\Http\Services;

class UploadSongsService
{
    /**
     *  Upload Songs Function
     *@return void
     *
     *@param  object $file
     */
    public function uploadSongs($file)
    {
        $original_name = $file->getClientOriginalName();
        $file->storeAs('public/songs/' . auth()->user()->id, $original_name);
    }
}
