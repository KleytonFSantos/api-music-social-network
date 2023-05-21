<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserProfile;
use App\Models\Song;
use App\Models\Video;
use App\Models\Post;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'description',
        'avatar',
        'city',
        'state',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userProfile(): HasOne
    {
       return $this->hasOne(UserProfile::class);
    }

    public function song(): HasMany
    {
       return $this->hasMany(Song::class);
    }

    public function video(): HasMany
    {
       return $this->hasMany(Video::class);
    }

    public function post(): HasMany
    {
       return $this->hasMany(Post::class);
    }

    public function findUserByEmail($email): User
    {
        return $this->where('email', $email)->first();
    }
}
