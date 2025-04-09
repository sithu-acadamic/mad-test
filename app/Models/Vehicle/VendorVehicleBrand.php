<?php

namespace App\Models\Vehicle;

use App\Models\Vendor\VendorCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorVehicleBrand extends Model
{
    use HasFactory;

    protected $table = "vendor_vehicle_brands";


    public function vendorBrands()
    {
        return $this->hasMany(Brand::class, 'id', 'brand_id');
    }

    public function vendorCompany()
    {
        return $this->hasMany(VendorCompany::class, 'id', 'vendor_company_id');
    }

    public function vendorBrandParts()
    {
        return $this->hasMany(VendorParts::class, 'vendor_vehicle_brand_id', 'id');
    }
}
