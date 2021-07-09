<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    // protected $table = "post";
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id', 'thumbnail'];
    // protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
