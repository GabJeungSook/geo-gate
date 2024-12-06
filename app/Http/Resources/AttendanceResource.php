<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'event_schedule_id' => $this->event_schedule_id,
            'user_id' => $this->user_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'in' => $this->in ? \Carbon\Carbon::parse($this->in)->format('g:i A') : null,
            'out' => $this->out ? \Carbon\Carbon::parse($this->out)->format('g:i A') : null,
            'geofence_out' => $this->geofence_out ? \Carbon\Carbon::parse($this->geofence_out)->format('l, F j, Y g:i A') : null,
            'is_present' => $this->is_present,
            'event_schedule' => new EventScheduleResource($this->whenLoaded('eventSchedule')),
            'user' => new UserResource($this->whenLoaded('user')),
            'event' => new EventDetailsResource($this->whenLoaded('event')),
        ];
    }
}
    