<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Scopes\DeleteAdminScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    protected $fillable=['title','content','user_id'];
    use HasFactory;
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'blog_posts_id')->latest();
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

        // static::addGlobalScope(new DeleteAdminScope);
        // static::addGlobalScope(new LatestScope);

        // static::deleting(function (BlogPost $blogPost) {
        //     $blogPost->comments()->delete();
        // });

        // static::restoring(function (BlogPost $blogPost) {
        //     $blogPost->comments()->restore();
        // });
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
