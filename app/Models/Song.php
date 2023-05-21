<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'artist',
        'cover',
        'namefile',
        'user_id',
    ];

    public function findSongById($user, $song): ?Song
    {
        return $this->query()
            ->where('user_id', $user)->where('id', $song)->first();

    }
}
