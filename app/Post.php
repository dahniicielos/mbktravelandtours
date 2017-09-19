<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\Category')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'post');
    }

    public function media()
    {
        return $this->hasOne('App\Media', 'id');
    }
}