<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\EventSchedule;
use App\Notifications\MarkAbsent;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'event_schedule_id' => 'required|exists:event_schedules,id',
        ]);

        $attendances = Attendance::withRelations()
            ->where('event_schedule_id', $request->event_schedule_id)
            ->get();

        return ApiResponse::success($attendances, 'Attendance data retrieved successfully');
    }

    /**
     * Check-in function.
     */
    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'event_schedule_id' => 'required|exists:event_schedules,id',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $attendance = Attendance::firstOrNew([
                'event_schedule_id' => $validated['event_schedule_id'],
                'user_id' => $request->user()->id,
            ]);

            $attendance->latitude = $validated['latitude'];
            $attendance->longitude = $validated['longitude'];
            $attendance->in = Carbon::now();
            $attendance->is_present = true; // Mark as present during check-in
            $attendance->save();

            DB::commit();

            return ApiResponse::success([], 'Checked in successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to check in', 500);
        }
    }

    /**
     * Check-out function.
     */
    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'event_schedule_id' => 'required|exists:event_schedules,id',
        ]);

        $attendance = Attendance::where('event_schedule_id', $validated['event_schedule_id'])
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$attendance || !$attendance->in) {
            return ApiResponse::error('No check-in record found', 404);
        }

        $attendance->out = Carbon::now();
        $attendance->save();

        return ApiResponse::success([], 'Checked out successfully');
    }

 
    public function markAbsent(Request $request)
    {
        $validated = $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
        ]);
    
        
        $attendance = Attendance::find($validated['attendance_id']);
    
        if (!$attendance) {
            return ApiResponse::error('Attendance record not found.', 404);
        }
    
       
        $eventSchedule = $attendance->eventSchedule;
        if (!$eventSchedule || !$eventSchedule->is_active) {
            return ApiResponse::error('Cannot mark absent. The event schedule is not active.', 400);
        }
    
       
        $attendance->is_present = false;
        $attendance->geofence_out = Carbon::now(); 
        $attendance->save();
        $user = $request->user();
        $user->notify(new MarkAbsent($user->id, 'Mark as absent', $user->userDetails->full_name));

            foreach ($user->deviceTokens() as $token) {
                FCMController::sendPushNotification(
                    $token,
                    'Absent Notification',
                    "You have been marked as absent for the event '{$eventSchedule->event->event_description}' on " . Carbon::now()->format('l, F j, Y g:i A'),
                    [
                        'user_id' => $user->id,
                        'notification' => 'absent_notification',
                    ]
                );
                
            }
    
        return ApiResponse::success([], 'User marked as absent successfully');
    }
    

   
    public function updateGeofenceOut(Request $request)
    {
        $validated = $request->validate([
            'event_schedule_id' => 'required|exists:event_schedules,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $attendance = Attendance::where('event_schedule_id', $validated['event_schedule_id'])
            ->where('user_id', $validated['user_id'])
            ->first();

        if (!$attendance) {
            return ApiResponse::error('Attendance record not found', 404);
        }

        $attendance->geofence_out = Carbon::now();
        $attendance->save();

        return ApiResponse::success([], 'Geofence out time updated successfully');
    }
}
