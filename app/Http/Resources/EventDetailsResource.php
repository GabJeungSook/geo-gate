<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailsResource extends JsonResource
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
            'event_description' => $this->event_description ?? null,
            'start_date' => $this->start_date ? $this->formattedDate($this->start_date) : null,
            'end_date' => $this->end_date ? $this->formattedDate($this->end_date) : null,
            'is_active' => $this->is_active ?? null,
            'campus' => new CampusResource($this->whenLoaded('campus')),
            
        ];
    }
}
