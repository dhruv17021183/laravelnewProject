<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Scopes\DeleteAdminScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{

    protected $fillable=['title','content','user_id'];
    use HasFactory;
    use SoftDeletes;
    
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }
    public function scopeMostCommented(Builder $query)
    {
        // comments_count
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }
    
    public static function boot()
    {
        parent::boot();

    //     static::addGlobalScope(new DeleteAdminScope);
    //     static::addGlobalScope(new LatestScope);

        // static::deleting(function (BlogPost $blogPost) {
        //     $blogPost->comments()->delete();
        //     $blogPost->image()->delete();
        //     Cache::tags(['blog-post'])->forget("blog-post-$blogPost->id}");
        // });

        // static::updating(function (BlogPost $blogPost){
        //     Cache::forget("blog-post-{$blogPost->id}");
        // });
        // static::restoring(function (BlogPost $blogPost) {
        //     $blogPost->comments()->restore();
        // });
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag','taggable')->withTimestamps();
    }
    public function image()
    {
        // return $this->hasOne('App\Models\Image'); //This Is One To One Relationship
        return $this->morphOne('App\Models\Image','imagable');

    }
}
