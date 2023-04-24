<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AwardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Award::create([
            'name' => 'No-Lifer',
            'description' => 'Awarded to users who have posted at least 100 times.',
            'post_count' => 100,
        ]);

        Award::create([
            'name' => 'Super Poster',
            'description' => 'Awarded to users who have posted at least 80 times.',
            'post_count' => 80,
        ]);

        Award::create([
            'name' => 'Mega Poster',
            'description' => 'Awarded to users who have posted at least 60 times.',
            'post_count' => 60,
        ]);

        Award::create([
            'name' => 'Active Poster',
            'description' => 'Awarded to users who have posted at least 40 times.',
            'post_count' => 40,
        ]);

        Award::create([
            'name' => 'Frequent Poster',
            'description' => 'Awarded to users who have posted at least 20 times.',
            'post_count' => 20,
        ]);

        Award::create([
            'name' => 'Regular Poster',
            'description' => 'Awarded to users who have posted at least 10 times.',
            'post_count' => 10,
        ]);

        Award::create([
            'name' => 'Newbie Poster',
            'description' => 'Awarded to users who have posted at least 5 times.',
            'post_count' => 5,
        ]);

        Award::create([
            'name' => 'Good Samaritan',
            'description' => 'Awarded to users who have made at least 100 replies.',
            'reply_count' => 100,
        ]);

        Award::create([
            'name' => 'Helpful Responder',
            'description' => 'Awarded to users who have made at least 80 replies.',
            'reply_count' => 80,
        ]);

        Award::create([
            'name' => 'Generous Replier',
            'description' => 'Awarded to users who have made at least 60 replies.',
            'reply_count' => 60,
        ]);

        Award::create([
            'name' => 'Active Responder',
            'description' => 'Awarded to users who have made at least 40 replies.',
            'reply_count' => 40,
        ]);

        Award::create([
            'name' => 'Frequent Replier',
            'description' => 'Awarded to users who have made at least 20 replies.',
            'reply_count' => 20,
        ]);

        Award::create([
            'name' => 'Casual Replier',
            'description' => 'Awarded to users who have made at least 10 replies.',
            'reply_count' => 10,
        ]);

        Award::create([
            'name' => 'Newbie Responder',
            'description' => 'Awarded to users who have made at least 5 replies.',
            'reply_count' => 5,
        ]);


        Award::create([
            'name' => 'King of Reactions',
            'description' => 'Awarded to users who have received at least 1000 reactions on their posts.',
            'reaction_count' => 1000,
        ]);

        Award::create([
            'name' => 'React Master',
            'description' => 'Awarded to users who have received at least 500 reactions on their posts.',
            'reaction_count' => 500,
        ]);

        Award::create([
            'name' => 'React Pro',
            'description' => 'Awarded to users who have received at least 250 reactions on their posts.',
            'reaction_count' => 250,
        ]);

        Award::create([
            'name' => 'React King',
            'description' => 'Awarded to users who have received at least 100 reactions on their posts.',
            'reaction_count' => 100,
        ]);

        Award::create([
            'name' => 'React Guru',
            'description' => 'Awarded to users who have received at least 50 reactions on their posts.',
            'reaction_count' => 50,
        ]);

        Award::create([
            'name' => 'React Fanatic',
            'description' => 'Awarded to users who have received at least 25 reactions on their posts.',
            'reaction_count' => 25,
        ]);

        Award::create([
            'name' => 'React Enthusiast',
            'description' => 'Awarded to users who have received at least 10 reactions on their posts.',
            'reaction_count' => 10,
        ]);

        Award::create([
            'name' => 'React Novice',
            'description' => 'Awarded to users who have received at least 5 reactions on their posts.',
            'reaction_count' => 5,
        ]);

    }
}
