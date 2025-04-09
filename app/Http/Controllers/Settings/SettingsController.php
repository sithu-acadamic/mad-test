<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnershipLogoRequest;
use App\Http\Requests\UpdateSectionImageRequest;
use App\Models\Settings\PartnershipLogo;
use App\Models\Settings\SectionSettingImage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $sections = SectionSettingImage::latest()->paginate(6);
        return view('settings.index', compact('sections'));
    }

    public function updateSectionImage(UpdateSectionImageRequest $request)
    {
        $sectionCode = $request->input('section');
        $imageFile = $request->file('image');

        // Find the section by section_code
        $section = SectionSettingImage::where('section_code', $sectionCode)->first();

        if ($section) {
            // Upload Image
            $imagePath = $imageFile->store('uploads', 'public'); // Use Laravel's built-in file storage

            // Update Section with the new image path
            $section->update(['image' => $imagePath]);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully!',
                'image' => asset('storage/' . $imagePath) // Make sure to return a full URL to the image
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Section not found!'
        ]);
    }


    /*public function updateSectionImage(UpdateSectionImageRequest $request)
    {
        $sectionCode = $request->input('section');
        $imageFile = $request->file('image');

        // Find the section by col_code
        $section = SectionSettingImage::where('section_code', $sectionCode)->first();

        if ($section) {
            // Upload Image
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('uploads'), $imageName);
            $imagePath = 'uploads/' . $imageName;

            // Update Section
            $section->update(['image' => $imagePath]);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully!',
                'image' => $imagePath
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Section not found!'
        ]);
    }*/
}
