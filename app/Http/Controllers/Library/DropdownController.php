<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DropdownController extends Controller
{
    public function getSupplier(Request $request)
    {
        $search_text = trim($request->q);

        if (empty($search_text)) {
            return \Response::json([]);
        }

        $brands = Brand::where('name','LIKE',$search_text.'%')->get();

        $formatted_tags = [];

        foreach ($brands as $brand) {
            $formatted_tags[] = ['id' => $brand->id, 'text' => $brand->name];
        }

        return \Response::json($formatted_tags);
    }

    public function getParts(Request $request)
    {
        $search_text = trim($request->q);

        if (empty($search_text)) {
            return \Response::json([]);
        }

        $brands = Parts::where('name','LIKE',$search_text.'%')->get();

        $formatted_tags = [];

        foreach ($brands as $brand) {
            $formatted_tags[] = ['id' => $brand->id, 'text' => $brand->name];
        }

        return \Response::json($formatted_tags);
    }
}
