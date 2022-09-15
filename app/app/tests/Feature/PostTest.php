<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Carbon\Factory;
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

    public function testNoBlogPostsWhenThereIs1WithNoComment()
    {
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);
    }

    public function testSee1BlogPostWithComments()
    {

        $post = $this->createDummyBlogPost();

        Comment::factory()->count(3)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('3 comments');

    }
    public function testStoreVaild()
    {

        $params = [
            'title' => 'Vaild title',
            'content' => 'At least 10 characters',
        ];
        $user = $this->user();

        $this->actingAs($user)
            ->post('/posts', $params)
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

        $this->actingAs($this->user())
            ->post('/posts', $params)
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
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        // Assert
        $this->assertDatabaseHas('blog_posts', $post->getAttributes());
        
        $params = [
            'title' => 'a new named title',
            'content' => 'Content was changed',
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', $post->getAttributes());

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'a new named title',
            'content' => 'Content was changed',
            'updated_at' => $carbon,
            'created_at' => $post->created_at,
        ]);
    }

    public function testDelete()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->getAttributes());
        
        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was deleted!');

        // $this->assertDatabaseMissing('blog_posts', $post->getAttributes());

        $this->assertSoftDeleted('blog_posts', $post->getAttributes());
    }

    public function createDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        $post = BlogPost::factory()->newTitle()->create([
            'user_id' => $userId ?? $this->user()->id,
        ]);
        
        return $post;
    }

}
