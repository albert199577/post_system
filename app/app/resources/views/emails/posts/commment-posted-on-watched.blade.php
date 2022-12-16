@component('mail::message')
# Comment was posted on your blog post

Hi {{ $comment->commentable->user->name }}
Someone has commented on your blog post

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
