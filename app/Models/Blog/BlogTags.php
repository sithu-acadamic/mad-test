<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTags extends Model
{
    use HasFactory;

    protected $table = 'blogs_tags';
    protected $fillable = ['blog_id', 'tags'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
