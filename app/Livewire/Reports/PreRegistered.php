<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\PreRegistration;

class PreRegistered extends Component
{
    public $pre_registered;
    public function render()
    {
        $this->pre_registered = PreRegistration::whereHas('eventSchedule', function ($query) {
            $query->where('is_active', 1);
        })->get();
        
        return view('livewire.reports.pre-registered', [
            'registrations' => $this->pre_registered,
        ]);
    }
}
