<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSettingImage extends Model
{
    use HasFactory;

    protected $table = 'sections_images';

    protected $fillable = ['section_code', 'image']; // Define fillable fields
}
