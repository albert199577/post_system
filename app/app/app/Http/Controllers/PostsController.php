<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    private $posts = [
        1 => [
            'title' => 'Intro to Laravel',
            'content' => 'This is a short intro to Laravel',
            'is_new' => true,
            'has_comments' => true
        ],
        2 => [
            'title' => 'Intro to PHP',
            'content' => 'This is a short intro to PHP',
            'is_new' => false,
            'has_comment' => false
        ],
        3 => [
            'title' => 'Intro to GO',
            'content' => 'This is a short intro to GO',
            'is_new' => false,
            'has_comment' => false
        ]
    ];

    public function __construct()
    {   
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destory']);
        // $this->middleware('locale');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());
        // $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-commented', 60, function () {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });

        // $mostActive = Cache::remember('users-most-active', 60, function () {
        //     return User::withMostBlogPost()->take(5)->get();
        // });

        // $mostActiveUserLastMonth = Cache::remember('users-most-active-last-month', 60, function () {
        //     return User::withMostBlogPostLastMonth()->take(5)->get();
        // });

        return view(
            'posts.index',
            [
                'posts' => BlogPost::latestWithRelations()->get(),
                // 'mostCommented' => $mostCommented,
                // 'mostActive' => $mostActive,
                // 'mostActiveUserLastMonth' => $mostActiveUserLastMonth,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        
        // dump($hasFile);
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
            
            // dump($file);
            // dump($file->getClientMimeType());
            // dump($file->getClientOriginalExtension());

            // dump($file->store('thumbnails'));
            // dump(Storage::disk('public')->putFile('thumbnails', $file));

            // $name1 = $file->storeAs('thumbnails', $post->id . '.' . $file->getClientOriginalExtension());
            // $name2 = Storage::disk('local')->putFileAs('thumbnails', $file, $post->id . '.' . $file->getClientOriginalExtension());

            // dump(Storage::url($name1));
            // dump(Storage::disk('local')->url($name2));
        }
        // die;

        $this->authorize($post);

        event(new BlogPostPosted($post));

        // $post->save();
        $request->session()->flash('status', 'The blog post was created!');
        return redirect()->route('posts.show', ['post' => $post->id]);
        // dd($request);
    }

    /**
     * Restore a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = BlogPost::findOrFail($id);
        
        $post->restore();
        session()->flash('status', 'The blog post was restored!');

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);

        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments' => function ($query) {
        //         return $query->latest();
        //     }])->findOrFail($id)
        // ]);

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                // ->with('tags')
                // ->with('user')
                // ->with('comments.user')
                ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();
        // dd($users);

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $diffrence--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
            ) {
                $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);


        if (!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $diffrence);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);
        
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post");
        // };

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post");
        // };

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'The blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog post");
        // };

        $post->delete();

        session()->flash('status', 'The blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
