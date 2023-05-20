<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'namefile' => $this->song->getClientOriginalName(),
            'user_id' => auth()->user()->id,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|min:3|required',
            'song' => 'file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'namefile' => 'string',
            'artist' => 'string',
            'cover' => 'string',
            'user_id' => 'integer',
        ];
    }
}
