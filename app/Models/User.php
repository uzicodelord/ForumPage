<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'name_changed_at' => 'datetime',
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





    public function awards()
    {
        return $this->belongsToMany(Award::class)->withTimestamps();
    }

    public function getAwards()
    {
        $awards = [];

        $postCount = $this->posts()->count();
        if ($postCount >= 100) {
            $awards[] = Award::where('name', 'No-Lifer')->first();
        } elseif ($postCount >= 80) {
            $awards[] = Award::where('name', 'Super Poster')->first();
        } elseif ($postCount >= 60) {
            $awards[] = Award::where('name', 'Mega Poster')->first();
        } elseif ($postCount >= 40) {
            $awards[] = Award::where('name', 'Active Poster')->first();
        } elseif ($postCount >= 20) {
            $awards[] = Award::where('name', 'Frequent Poster')->first();
        } elseif ($postCount >= 10) {
            $awards[] = Award::where('name', 'Regular Poster')->first();
        } elseif ($postCount >= 5) {
            $awards[] = Award::where('name', 'Newbie Poster')->first();
        }



        // Check if the user has made at least 10 replies
        if ($this->replies()->count() >= 100) {
            $awards[] = Award::where('name', 'Good Samaritan')->first();
        } elseif ($this->replies()->count() >= 80) {
            $awards[] = Award::where('name', 'Helpful Responder')->first();
        } elseif ($this->replies()->count() >= 60) {
            $awards[] = Award::where('name', 'Generous Replier')->first();
        } elseif ($this->replies()->count() >= 40) {
            $awards[] = Award::where('name', 'Active Responder')->first();
        } elseif ($this->replies()->count() >= 20) {
            $awards[] = Award::where('name', 'Frequent Replier')->first();
        } elseif ($this->replies()->count() >= 10) {
            $awards[] = Award::where('name', 'Casual Replier')->first();
        } elseif ($this->replies()->count() >= 5) {
            $awards[] = Award::where('name', 'Newbie Responder')->first();
        }


        // Check if the user has received at least 25 reactions
        if ($this->reactions()->count() >= 1000) {
            $awards[] = Award::where('name', 'King of Reactions')->first();
        } elseif ($this->reactions()->count() >= 500) {
            $awards[] = Award::where('name', 'React Master')->first();
        } elseif ($this->reactions()->count() >= 250) {
            $awards[] = Award::where('name', 'React Pro')->first();
        } elseif ($this->reactions()->count() >= 100) {
            $awards[] = Award::where('name', 'React King')->first();
        } elseif ($this->reactions()->count() >= 50) {
            $awards[] = Award::where('name', 'React Guru')->first();
        } elseif ($this->reactions()->count() >= 25) {
            $awards[] = Award::where('name', 'React Fanatic')->first();
        } elseif ($this->reactions()->count() >= 10) {
            $awards[] = Award::where('name', 'React Enthusiast')->first();
        } elseif ($this->reactions()->count() >= 5) {
            $awards[] = Award::where('name', 'React Novice')->first();
        }

        // Add other award conditions here...

        return $awards;
    }


}
