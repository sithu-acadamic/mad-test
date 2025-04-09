<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = ['title', 'description', 'image', 'added_time', 'tags', 'status'];

    public function tags()
    {
        return $this->hasMany(BlogTags::class);
    }
}
