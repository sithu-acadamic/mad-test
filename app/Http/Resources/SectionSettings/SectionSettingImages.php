<?php

namespace App\Http\Resources\SectionSettings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionSettingImages extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => url('storage/' . $this->image),
            'section_code' => $this->section_code,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

}
