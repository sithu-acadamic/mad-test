<?php

namespace App\Http\Controllers\Inquiries;

use App\Http\Controllers\Controller;
use App\Models\Inquiries\Inquiries;
use App\Models\Inquiries\VendorInquiryMap;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VendorParts;
use App\Models\Vehicle\VendorVehicleBrand;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    public function index()
    {
        $inquiries = Inquiries::with(['customer.roles'])->get();
        return view('inquiries.index',compact('inquiries'));
    }

    public function inquiryDetails(Request $request)
    {
        $InquiryDetails = Inquiries::with(['customer.roles'])->find($request->inquiryId);
        return view('inquiries.components.inquiry-details',compact('InquiryDetails'));
    }

    public function getVendor(Request $request)
    {
        parse_str($request['f'], $filterData);

        $brands = VendorVehicleBrand::with(['vendorBrands', 'vendorCompany'])
            ->where('brand_id', $filterData['brand'])->get();

        if ($brands->isEmpty()) {
            return response()->json([]);
        }

        dd($brands);
        return view ('inquiries.components.available-shop',compact('brands'));
    }

    public function mapVendorToInquiry(Request $request)
    {

        $request->validate([
            'inquiry_id' => 'required|integer|exists:inquiries,id',
            'vendor_ids' => 'required|array',
            'vendor_ids.*' => 'integer|exists:users,id', // Replace `vendors` with your actual vendors table
        ]);

        foreach ($request->vendor_ids as $vendorId) {
            VendorInquiryMap::create([
                'inquiry_id' => $request->inquiry_id,
                'vendor_id' => $vendorId,
                'mapped_date' => now(), // Use Laravel's helper for the current date and time
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Vendors mapped successfully.']);
    }

}
