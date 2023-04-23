<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'rank',
        'points',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getRank()
    {
        $points = $this->points;

        if ($points >= 1000) {
            return 'Supreme';
        } elseif ($points >= 900) {
            return 'Overlord';
        } elseif ($points >= 800) {
            return 'Immortal';
        } elseif ($points >= 700) {
            return 'Divine';
        } elseif ($points >= 600) {
            return 'Hero';
        } elseif ($points >= 500) {
            return 'Legend';
        } elseif ($points >= 400) {
            return 'Grandmaster';
        } elseif ($points >= 300) {
            return 'Master';
        } elseif ($points >= 250) {
            return 'Elite';
        } elseif ($points >= 200) {
            return 'Veteran';
        } elseif ($points >= 150) {
            return 'Journeyman';
        } elseif ($points >= 100) {
            return 'Apprentice';
        } elseif ($points >= 50) {
            return 'Novice';
        } elseif ($points >= 20) {
            return 'Trainee';
        } else {
            return 'Peasant';
        }
    }
    public function updateRank()
    {
        $this->rank = $this->getRank();
        $this->save();
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function notify($data)
    {
        $this->notifications()->create([
            'message' => $data['message'],
            'url' => $data['url'],
        ]);
    }



}
