<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipLogo extends Model
{
    use HasFactory;

    protected $table = 'partnership_logo';
    protected $fillable = ['title', 'image', 'status'];
}
