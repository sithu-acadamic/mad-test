<?php

namespace App\Models\Inquiries;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiries extends Model
{
    use HasFactory;

    protected $table = 'inquiries';

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
