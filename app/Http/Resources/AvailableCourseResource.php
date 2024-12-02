<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CampusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'course_code' => $this->course_code,
            'course_description' => $this->course_description,
            'campus' => new CampusResource($this->whenLoaded('campus')), 
        ];
    }
}
