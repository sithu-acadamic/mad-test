<?php

namespace App\Models\Inquiries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInquiryMap extends Model
{
    use HasFactory;

    protected $table = 'vendor_request_map';

    protected $fillable = ['inquiry_id', 'vendor_id', 'mapped_date','status'];
}
