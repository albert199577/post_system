<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use DateTimeZone;
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

    public function testStoreVaild()
    {
        $params = [
            'title' => 'Vaild title',
            'content' => 'At least 10 characters',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        // dd($messages->getMessages());

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');

    }

    public function testUpdateVaild()
    {
        $carbon = Carbon::now(new DateTimeZone('Asia/Taipei'));

        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        // Assert
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'Content of the blog post',
            'updated_at' => $carbon->now(),
            'created_at' => $carbon->now(),
        ]);
        
        $params = [
            'title' => 'a new named title',
            'content' => 'Content was changed',
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New title',
            'content' => 'Content of the blog post',
            'updated_at' => $carbon->now(),
            'created_at' => $carbon->now(),
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'a new named title',
            'content' => 'Content was changed',
            'updated_at' => $carbon->now(),
            'created_at' => $carbon->now(),
        ]);
    }
}
