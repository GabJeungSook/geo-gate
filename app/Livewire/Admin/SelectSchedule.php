<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventSchedule;
use Filament\Notifications\Notification;

class SelectSchedule extends Component
{
    public $scannedCode;
    public $record;
    public $scanning = false; // Controls whether scanning UI is displayed
    public $action; // Stores the selected action: Time In or Time Out

    public function mount()
    {
        $this->record = EventSchedule::where('is_active', true)->first();
    }

    public function startScanning($action)
    {
        $this->action = $action; // Set the action (Time In or Time Out)
        $this->scanning = true; // Show the scanning input
    }

    public function stopScanning()
    {
        $this->scanning = false; // Reset the scanning state
        $this->scannedCode = null; // Clear the scanned code input if needed
    }

    public function verifyQR()
    {
        Notification::make()
        ->title('Success')
        ->body('successfully scanned qr code.')
        ->success()
        ->send();
         $this->scannedCode = null;
    }

    public function render()
    {
        return view('livewire.admin.select-schedule');
    }
}
