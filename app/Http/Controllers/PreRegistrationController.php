<?php

namespace App\Http\Controllers;

use is;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\EventSchedule;
use App\Models\PreRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PreRegistrationController extends Controller
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
        //
    }

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
    public function createOrUpdatePreRegistration(Request $request)
    {
        $validatedData = $request->validate([
            'event_schedule_id' => 'required|exists:event_schedules,id',
            'qr_code' => 'nullable|string',
        ]);
    
        $eventSchedule = EventSchedule::with('event')->findOrFail($validatedData['event_schedule_id']);
    
        
        if (!$eventSchedule->event->is_active) {
            return ApiResponse::error('The event is no longer active.', 409); 
        }
    
        if (!$eventSchedule->is_active) {
            return ApiResponse::error('The schedule is no longer active.', 400);
        }
    
        $existingPreRegistration = PreRegistration::where('event_schedule_id', $validatedData['event_schedule_id'])
            ->where('user_id', $request->user()->id)
            ->first();
    
        DB::beginTransaction();
    
        try {
            if ($existingPreRegistration) {
                $existingPreRegistration->update($validatedData);
                $message = 'Pre-registration updated successfully';
            } else {
                $validatedData['user_id'] = $request->user()->id;
                PreRegistration::create($validatedData);
                $message = 'Pre-registration created successfully';
            }
    
            DB::commit();
    
            return ApiResponse::success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('An error occurred while processing your pre-registration: ' . $e->getMessage(), 500);
        }
    }
    
    

}
