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
        'points'
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

        if ($points >= 500) {
            return 'Ultimate Overlord';
        } elseif ($points >= 400) {
            return 'Supreme Commander';
        } elseif ($points >= 300) {
            return 'Generalissimo';
        } elseif ($points >= 250) {
            return 'Grandmaster';
        } elseif ($points >= 200) {
            return 'Master';
        } elseif ($points >= 150) {
            return 'Veteran';
        } elseif ($points >= 100) {
            return 'Pro';
        } elseif ($points >= 50) {
            return 'Expert';
        } elseif ($points >= 20) {
            return 'Novice';
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
