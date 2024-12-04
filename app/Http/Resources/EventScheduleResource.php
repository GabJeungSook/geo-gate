<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventScheduleResource extends JsonResource
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
            'event_id' => $this->event_id,
            'event_name' => $this->event ? $this->event->name : null, 
            'schedule_date' => $this->schedule_date ? $this->schedule_date->format('l, F j, Y') : null, 
            'start_time' => $this->start_time ? $this->start_time->format('g:i A') : null, 
            'end_time' => $this->end_time ? $this->end_time->format('g:i A') : null, 
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('l, F j, Y g:i A'),
            'updated_at' => $this->updated_at->format('l, F j, Y g:i A'),
            'attendances' => AttendanceResource::collection($this->whenLoaded('attendances')),
            
        ];
    }
}
