<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use App\Models\BlogPost;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function blogposts()
    {
        return $this->hasMany('App\Models\BlogPost');
    }
    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count','desc');
    }
    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->withCount(['blogPosts' => function(Builder $query){
            $query->whereBetween(static::CREATED_AT,[now()->subMonth(3),now()]);
        }])
        ->having('blog_posts_count', '>=',2)
        ->orderBy('blog_posts_count','desc');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
    public function scopeThatHasCommentedOnPost(Builder $query,BlogPost $post)
    {
        /*
         we only want to fetch comments relation of user where those comments are 
           actually associated with specific blogpost 

        */
         $query->whereHas('comments',function($query) use($post){
            return $query->where('commentable_id','=',$post->id)
                 ->where('commentable_type','=',BlogPost::class);
        });
    }
    public function image()
    {
        // return $this->hasOne('App\Models\Image');
        return $this->morphOne('App\Models\Image','imagable');

    }
    public function commentsOn()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }
    public function scopeThatIsAdmin(Builder $query)
    {
        return $query->where('is_admin',true);
    }
}
