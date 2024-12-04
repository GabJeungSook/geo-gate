<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::create([
            'campus_id' => 1,
            'event_description'=>"KAMBUNIYAN 2024",
            'start_date' => '2024-12-03',
            'end_date' => '2024-12-04',
            'is_active' => '0',
        ]);
        $event->schedules()->create([
            'schedule_date'=>"2024-12-03",
            'start_time'=>"13:00",
            'end_time'=>"14:00",
            'is_active' => '0',
        ]);
        $event->schedules()->create([
            'schedule_date'=>"2024-12-03",
            'start_time'=>"15:00",
            'end_time'=>"16:00",
            'is_active' => '0',
        ]);
    }
}
