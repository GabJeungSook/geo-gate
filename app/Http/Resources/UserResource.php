<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->fullName(),
            'email' => $this->email,
            'role' => $this->role,
            'image' => $this->getImage(),
            'user_details' => new UserDetailsResource($this->whenLoaded('userDetails')),
            'course' => new CourseResource($this->whenLoaded('course')), // 
        ];
    }
}
