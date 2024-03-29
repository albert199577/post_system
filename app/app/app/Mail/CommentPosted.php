<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

//Comment 
class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Commented was posted on your {$this->comment->commentable->title} blog post";
        $path = $this->comment->user->image->path;
        return $this
            // first example with full path

            /*
            ->attach(
                storage_path('app/public') . '/' . $this->comment->user->image->path,
                [
                    'as' => 'porfile_pricture.jpeg',
                    'mime' => 'image/jpeg'
                ]
            )
            */
            // ->attachFromStorage($this->comment->user->image->path, 'profile_picture.jpeg')
            // ->attachFromStorageDisk('public', $this->comment->user->image->path)
            ->attachData(Storage::get($path), 'profile_picture_from_data.jpeg', [
                'mime' => Storage::mimetype($path)
            ])
            ->subject($subject)
            ->view('emails.posts.commented');
    }
}
