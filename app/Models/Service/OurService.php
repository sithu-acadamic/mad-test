<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    use HasFactory;

    protected $table = 'our_service';
    protected $fillable = ['title_one','title_two','title_one_color','status','title_two_color', 'description', 'image'];
}
