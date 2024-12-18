<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\EventScheduleResource;
use App\Http\Resources\PreRegistrationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $activeSchedule = $this->firstActiveSchedule(); 

        
        return [
            'id' => $this->id,
            'event_description' => $this->event_description ?? null,
            'start_date' => $this->start_date ? $this->formattedDate($this->start_date) : null,
            'end_date' => $this->end_date ? $this->formattedDate($this->end_date) : null,
            'is_active' => $this->is_active ?? null,
            'campus' => new CampusResource($this->whenLoaded('campus')),
            'event_schedules' => EventScheduleResource::collection($this->whenLoaded('eventSchedules')),
            'active_schedule' => $activeSchedule ? new EventScheduleResource($activeSchedule) : null,
          
            
        ];
    }

    private function formattedDate($date)
    {
        return \Carbon\Carbon::parse($date)->format('l, F j, Y'); // Format as 'Monday, December 4, 2024'
    }
}
