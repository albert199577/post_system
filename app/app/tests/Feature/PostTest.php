<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testNoBlogPostsWhenNothingInDatabase()
    // {
    //     $response = $this->get('/posts');
    //     // $this->assertTrue(true);

    //     $response->assertSeeText('No blog posts yet!');
    // }

    public function testNoBlogPostsWhenThereIs1()
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);
    }


}
