<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable,  CanResetPassword;

    protected $fillable = [
        'username', 'password', 'email', 'full_name', 'birth_date', 'profile_image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_user_id', 'follower_user_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_user_id', 'followed_user_id');
    }

    public function followerUsers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_user_id', 'follower_user_id');
    }

    public function followingUsers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_user_id', 'followed_user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
