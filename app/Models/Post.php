<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'user_id'
    ];

    public function allPosts()
    {
       return $this->select(
        'posts.id',
        'posts.title',
        'posts.image',
        'posts.description',
        'users.first_name',
        'users.last_name',
        'user_profile.profile_image',
        'posts.created_at',
       )->join(
        'users', 'users.id','=','posts.user_id',
       )->join(
        'user_profile', 'user_profile.user_id', '=','posts.user_id'
       )
       ->orderBy('created_at', 'desc')
       ->paginate(15);
    }
}
