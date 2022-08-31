<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use DateTimeZone;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = BlogPost::class;

    public function definition()
    {
        $carbon = Carbon::now(new DateTimeZone('Asia/Taipei'));

        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(5, true),
            'updated_at' => $carbon->now(),
            'created_at' => $carbon->now(),
        ];
    }

    public function newTitle()
    {

        return $this->state([
            'title' => 'New title',
            'content' => 'Content of the blog post',
        ]);
    }
}
