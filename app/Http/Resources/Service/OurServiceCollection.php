<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OurServiceCollection extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'image' => asset('storage/' . $this->image),
            'title_one' => $this->title_one,
            'title_two' => $this->title_two,
            'title_one_color' => $this->title_one_color,
            'title_two_color' => $this->title_two_color,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
