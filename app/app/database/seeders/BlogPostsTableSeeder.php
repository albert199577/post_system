<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogsCount = (int)$this->command->ask('How many blog posts would you like?', 50);
        $users = User::all();


        BlogPost::factory($blogsCount)->make()->each(function ($post) use($users) {
            $post->user_id = $users->random()->id;
            $post->save();
            // $post->user()->associate($users->random())->save();
        });
    }
}
