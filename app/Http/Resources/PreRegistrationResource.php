<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PreRegistrationResource extends JsonResource
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
            'qr_code' => $this->qr_code, 
            'user' => new UserResource($this->whenLoaded('user')), 
            'created_at' => $this->created_at->format('l, F j, Y g:i A'), 
            'updated_at' => $this->updated_at->format('l, F j, Y g:i A'), 
        ];
    }
}
