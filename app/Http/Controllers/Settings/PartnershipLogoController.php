<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnershipLogoRequest;
use App\Models\Settings\PartnershipLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PartnershipLogoController extends Controller
{
    public function index()
    {
        $logos = PartnershipLogo::orderBy('created_at', 'desc')->paginate(5);
        return view('partnershipLogo.index', compact('logos'));
    }

    public function store(PartnershipLogoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $data['status'] = 1;
        PartnershipLogo::create($data);

        return response()->json(['success' => true, 'message' => 'Logo added successfully']);
    }

    public function edit($id)
    {
        $logo = PartnershipLogo::findOrFail($id);
        return response()->json($logo);
    }

//    public function update(PartnershipLogoRequest $request, $id)
//    {
//        $logo = PartnershipLogo::findOrFail($id);
//        $data = $request->validated();
//
//        if ($request->hasFile('image')) {
//            Storage::disk('public')->delete($logo->image);
//            $data['image'] = $request->file('image')->store('uploads', 'public');
//        }
//
//        $logo->update($data);
//
//        return response()->json(['success' => true, 'message' => 'Logo updated successfully']);
//    }

    public function update(PartnershipLogoRequest $request, $id)
    {
        $data = $request->validated();
        $logo = PartnershipLogo::findOrFail($id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        } else {
            $data['image'] = $request->existing_image; // Keep the existing image
        }

        $logo->update($data);

        return response()->json(['success' => true, 'message' => 'Logo updated successfully']);
    }


    public function destroy($id)
    {
        $logo = PartnershipLogo::findOrFail($id);
        Storage::disk('public')->delete($logo->image);
        $logo->delete();

        return response()->json(['success' => true, 'message' => 'Logo deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $logo = PartnershipLogo::findOrFail($id);
        $logo->status = !$logo->status;
        $logo->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}
