<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GoogleReviewCollection extends JsonResource
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
            'username' => $this->username,
            'review_message' => $this->review_message,
            'star_rating' => $this->star_rating,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
