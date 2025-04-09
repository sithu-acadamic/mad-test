<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\OurServiceRequest;
use App\Models\Service\OurService;
use Illuminate\Http\Request;

class OurServiceController extends Controller
{
    public function index()
    {
        $services = OurService::latest()->paginate(5);
        return view('service.index', compact('services'));
    }

    /*public function store(OurServiceRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $data['status'] = 1;
        OurService::create($data);

        return response()->json(['success' => true, 'message' => 'Service added successfully']);
    }*/

    public function store(OurServiceRequest $request)
    {
        $data = $request->validated();

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        // Handle checkbox statuses for title colors

        $data['title_one_color'] = $request->title_one_color;
        $data['title_two_color'] = $request->title_two_color;
        $data['status'] = 1;
        // Create the service

        OurService::create($data);

        return response()->json(['success' => true, 'message' => 'Service added successfully']);
    }


    public function edit($id)
    {
        $service = OurService::findOrFail($id);
        return response()->json($service);
    }

    public function update(OurServiceRequest $request, $id)
    {
        $service = OurService::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }
        $data['title_one_color'] = $request->title_one_color;
        $data['title_two_color'] = $request->title_two_color;

        $data['status'] = 1;
        $service->update($data);

        return response()->json(['success' => true, 'message' => 'Service updated successfully']);
    }

    public function destroy($id)
    {
        $service = OurService::findOrFail($id);
        $service->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $service = OurService::findOrFail($id);

        if($service->status == 0){
            $service->status = 1;
        }else{
            $service->status = 0;
        }
       // $service->status = !$service->status; // Toggle status
        $service->save();

        return response()->json(['message' => 'Service status updated successfully!']);
    }


}
