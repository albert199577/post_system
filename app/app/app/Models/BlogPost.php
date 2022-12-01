<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\DeleteAdminScope;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];
    
    use HasFactory;

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function image()
    {
        // return $this->hasOne('App\Models\Image');
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('comments')
            ->with('tags')
            ->with('user');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeleteAdminScope);
        
        parent::boot();

        // static::addGlobalScope(new LatestScope);

        static::updating(function (BlogPost $blogPost) {
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
            $blogPost->image()->delete();
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });

    }
}
