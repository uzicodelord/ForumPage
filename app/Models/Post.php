<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function getAverageRatingAttribute()
    {
        $totalVotes = $this->upvotes + $this->downvotes;
        if ($totalVotes == 0) {
            return 0;
        }
        $ratio = $this->upvotes / $totalVotes;
        return round($ratio * 5);
    }

}
