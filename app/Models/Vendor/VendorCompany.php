<?php

namespace App\Models\Vendor;

use App\Models\Vehicle\VendorVehicleBrand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorCompany extends Model
{
    use HasFactory;

    protected $table = 'vendor_company';
}
