<?php

namespace App\Models\Review;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    use HasFactory;

    protected $table = 'google_review';

    protected $fillable = ['username', 'review_message', 'star_rating', 'status'];
}
