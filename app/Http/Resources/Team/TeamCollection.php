<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'image' => asset('storage/' . $this->image),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'designation' => $this->designation,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
