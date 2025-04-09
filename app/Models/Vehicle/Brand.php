<?php

namespace App\Models\Vehicle;

use App\Models\Vendor\VendorCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'vehicle_brands';


  /*  public function vendorBrands()
    {
        return $this->hasMany(VendorVehicleBrand::class, 'brand_id', 'id');
    }*/

//    public function vendorCompany()
//    {
//        return $this->hasMany(VendorCompany::class, 'vendor_company_id', 'id');
//    }
}
