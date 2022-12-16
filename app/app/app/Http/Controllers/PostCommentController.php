<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Models\Comment;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPost $post, StoreComment $request)
    {
        // dd($request);

        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // dd($comment->user->image->url());
        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment)
        // );
        // $when = now()->addMinutes(1);

        // Mail::to($post->user)->queue(
        //     new CommentPostedMarkdown($comment)
        // );

        ThrottledMail::dispatch(new CommentPostedMarkdown($comment), $post->user);

        NotifyUsersPostWasCommented::dispatch($comment);
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );
        // $comment = new Comment();
        // $comment->blog_post_id = $request->blog_post_id;
        // $comment->content = $request->content;

        // $comment->save();
        // $request->session()->flash('status', 'Comment was created!');

        return redirect()->back()->withStatus('Comment was created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
