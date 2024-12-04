<?php

namespace App\Http\Controllers;


use App\Models\Event;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    // public function show($councilId, $eventId)
    // {
    //     $event = Event::where('council_id', $councilId)
    //     ->withRelation()
    //         ->findOrFail($eventId);

    //     return ApiResponse::success(new EventResource($event), 'Event retrieved successfully');
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getActiveEvent(){
        $event = Event::activeEvent()->withRelations()->first();
         return ApiResponse::success(new EventResource($event), 'Event retrieved successfully');
    }

    public function getActiveSchedule(Request $request, $eventId)
{
  
    $event = Event::withRelations()->findOrFail($eventId);

    
    if (!$event->is_active) {
        return ApiResponse::error('This event is no longer active.', 400); // Return error if not active
    }

    return ApiResponse::success(new EventResource($event), 'Event retrieved successfully');
}

}
