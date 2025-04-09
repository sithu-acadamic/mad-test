<?php

namespace App\Http\Resources\PartnersLogo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PartnerLogoCollection extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'image' => asset('storage/' . $this->image),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
