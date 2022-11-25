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

    public function likeExists(int $user_id,int $post_id)
    {
        return $this::where('user_id', $user_id)->where('post_id', $post_id)->first();
    }
}
