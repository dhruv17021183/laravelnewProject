<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Comment extends Model
{
    use HasFactory;
    protected $fillable=['user_id','content'];
    // public function post()
    // {
    //     return $this->belongsTo('App\Models\BlogPost');
    // }
    // public function scopeLatest(Builder $query)
    // {
    //     return $query->orderBy(static::CREATED_AT,'desc');
    // }
    public function commentable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag','taggable')->withTimestamps();
    }
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }
}
