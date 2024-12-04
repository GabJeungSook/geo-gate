<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserDetailsResource extends JsonResource
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
            'user_id' => $this->user_id,
            'first_name' => $this->first_name ?? null,
            'last_name' => $this->last_name ?? null,
            'full_address' => $this->full_address ?? null,
            'fullname' => $this->full_name, 
            'birthday' => $this->birthday ? Carbon::parse($this->birthday)->format('F d, Y') : null,
            'course' => $this->course_id ?? null,

           
        ];
}
}