<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'liked',
    ];

    public function likeExists(int $post_id,int $user_id)
    {
        return $this::where('user_id', $user_id)->where('post_id', $post_id)->first();
    }

    public function qtdLikes(int $post_id)
    {
        return $this::where('post_id', $post_id)->where('liked', 1)->count();
    }
}
