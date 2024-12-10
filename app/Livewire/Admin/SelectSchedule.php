<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\PreRegistration;
use App\Models\Attendance;
use Filament\Notifications\Notification;

class SelectSchedule extends Component
{
    public $scannedCode;
    public $record;
    public $scanning = false; // Controls whether scanning UI is displayed
    public $action; // Stores the selected action: Time In or Time Out
    public $attendance;

    public function mount()
    {
        $this->record = EventSchedule::where('is_active', true)->first();
        $this->attendance = Attendance::where('event_schedule_id', $this->record->id)->get();
    }

    public function startScanning($action)
    {
        $this->action = $action; // Set the action (Time In or Time Out)
        $this->scanning = true; // Show the scanning input
        if($this->action === 'Time In')
        {
            $this->attendance = Attendance::where('event_schedule_id', $this->record->id)->whereNotNull('in')->get();
        }else{
            $this->attendance = Attendance::where('event_schedule_id', $this->record->id)->whereNotNull('out')->get();
        }
    }

    public function stopScanning()
    {
        $this->scanning = false; // Reset the scanning state
        $this->scannedCode = null; // Clear the scanned code input if needed
    }

    public function verifyQR()
    {
        // Check if the scanned code exists in the PreRegistration table
        $user = PreRegistration::where('qr_code', $this->scannedCode)->first();
    
        if (!$user) {
            Notification::make()
                ->title('Operation Failed')
                ->body('User pre-registration not found.')
                ->danger()
                ->send();
            $this->scannedCode = null;
            return;
        }
    
        // Parse the QR code
        $parts = explode('-', $this->scannedCode);
        $data = [
            'event_schedule_id' => $parts[1] ?? null,
            'user_id' => $parts[2] ?? null,
            'latitude' => $parts[3] ?? null,
            'longitude' => $parts[4] ?? null,
        ];
    
        // Validate if user is within the event radius
        $event = EventSchedule::find($data['event_schedule_id'])->event;
        if (!$event) {
            Notification::make()
                ->title('Invalid Event')
                ->body('Event not found for this schedule.')
                ->danger()
                ->send();
            $this->scannedCode = null;
            return;
        }
    
        $eventLatitude = $event->campus->latitude;
        $eventLongitude = $event->campus->longitude;
        $radiusInMeters = $event->campus->radius ?? 100; // Default radius is 100 meters if not set
    
        $distance = $this->haversineDistance($data['latitude'], $data['longitude'], $eventLatitude, $eventLongitude);
    
        if ($distance > $radiusInMeters) {
            Notification::make()
                ->title('Out of Range')
                ->body('User is outside the allowed event radius.')
                ->danger()
                ->send();
            $this->scannedCode = null;
            return;
        }
    
        // Process Time In or Time Out
        if ($this->action === 'Time In') {
            $this->processTimeIn($data, $user);
        } elseif ($this->action === 'Time Out') {
            $this->processTimeOut($data, $user);
        }
    
        // Clear the scanned code input for the next scan
        $this->scannedCode = null;
    }
    
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth radius in meters
    
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
    
        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;
    
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($lat1) * cos($lat2) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        return $earthRadius * $c; // Distance in meters
    }
    
    private function processTimeIn($data, $user)
    {
        // Check if the user already has a Time In for this schedule
        $existingAttendance = Attendance::where('event_schedule_id', $data['event_schedule_id'])
            ->where('user_id', $data['user_id'])
            ->whereNotNull('in')
            ->first();
    
        if ($existingAttendance) {
            Notification::make()
                ->title('Duplicate Entry')
                ->body('User has already scanned for Time In.')
                ->warning()
                ->send();
        } else {
            // Record Time In
            $data['in'] = now();
            $data['is_present'] = 1;
    
            Attendance::create($data);
    
            Notification::make()
                ->title('Success')
                ->body('Successfully scanned QR code for ' . $user->user->name)
                ->success()
                ->send();
            $this->attendance = Attendance::where('event_schedule_id', $this->record->id)->get();
        }
    }
    
    private function processTimeOut($data, $user)
    {
        // Check if the user has a valid Time In for this schedule
        $attendance = Attendance::where('event_schedule_id', $data['event_schedule_id'])
            ->where('user_id', $data['user_id'])
            ->whereNotNull('in')
            ->whereNull('out') // Ensure no Time Out is recorded yet
            ->first();
    
        if ($attendance) {

            if($attendance->geofence_out != null)
            {
                Notification::make()
                ->title('Operation Failed')
                ->body('User already marked as absent')
                ->danger()
                ->send();
            }else{
                // Record Time Out
                $attendance->update([
                    'out' => now(),
                ]);

                Notification::make()
                    ->title('Success')
                    ->body('Successfully recorded Time Out for ' . $user->user->name)
                    ->success()
                    ->send();
            }
           
        } else {
            Notification::make()
                ->title('Operation Failed')
                ->body('No valid Time In record found for Time Out.')
                ->danger()
                ->send();
        }
    }
    
    

    public function render()
    {
        return view('livewire.admin.select-schedule');
    }
}
