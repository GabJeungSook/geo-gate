<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Attendance as AttendanceModel;

class Attendance extends Component
{
    public $attendances;
    public function render()
    {
        $this->attendances = AttendanceModel::whereHas('eventSchedule', function ($query) {
            $query->where('is_active', 1);
        })->whereNotNull('out')->get();

        return view('livewire.reports.attendance', [
            'attendance' => $this->attendances,
        ]);
    }
}
