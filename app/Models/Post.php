<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'user_id'
    ];

    public function like(): HasMany
    {
       return $this->hasMany(Like::class)->where('liked', true);
    }

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
       ->paginate(7);
    }

    public function findPostsByUserId(): ?Collection
    {
       return Auth::user()->post()->get();
    }

    public function findPostById(int $post): ?Collection
    {
        return $this->query()
            ->where('user_id', Auth::user()->id)
            ->where('id', $post)
            ->get();
    }

    public function createPost($post): Builder|Model
    {
        return $this->query()
            ->create($post);
    }
}
