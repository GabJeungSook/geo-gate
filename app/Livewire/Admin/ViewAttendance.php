<?php

namespace App\Livewire\Admin;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventSchedule;
use Livewire\Component;

class ViewAttendance extends Component implements HasForms, HasTable 
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $eventSchedule; // ID of the event schedule to fetch
    public $users = []; // To store user attendance data
    public $event = null; // To store event details

    public function mount()
    {
        
        $this->eventSchedule = EventSchedule::where('is_active', 1)->first();
        $this->loadData();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Attendance::query())
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('in')->label('TIme In')->formatStateUsing(fn ($record) => Carbon::parse($record->in)->format('h:i A')),
                TextColumn::make('in')->label('TIme Out')->formatStateUsing(fn ($record) => Carbon::parse($record->out)->format('h:i A')),
                TextColumn::make('is_present')->label('Status')
                ->formatStateUsing(fn ($record) => $record->is_present ? 'PRESENT' : 'ABSENT'),

                // TextColumn::make('start_time')->formatStateUsing(fn ($record) => Carbon::parse($record->start_time)->format('h:i A')),
                // TextColumn::make('end_time')->formatStateUsing(fn ($record) => Carbon::parse($record->end_time)->format('h:i A')),
               
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // Action::make('edit_schedule')
                // ->label('Edit')
                // ->icon('heroicon-o-pencil')
                // ->color('success')
                // ->url(fn (Campus $record): string => route('edit_campus', $record))
            ])
            ->headerActions([
                // Action::make('add_schedule')
                // ->label('Add Schedule')
                // ->color('success')
                // ->mountUsing(function (Form $form) {
                //     $form->fill([
                //         'schedule_dates' => $this->schedule_dates,
                //     ]);
                // })
                // ->form([
                //     Repeater::make('schedule_dates')
                //     ->label('')
                //     ->schema([
                //         DatePicker::make('date')
                //         ->native(false)
                //         ->disabled()
                //         ->reactive()
                //         ->required(),
                //         Repeater::make('time')
                //         ->schema([
                //             Grid::make(2)
                //             ->schema([
                //                 TimePicker::make('time_from')
                //                 ->seconds(false)
                //                 ->label('From')
                //                 ->reactive()
                //                 ->required(),
                //                 TimePicker::make('time_to')
                //                 ->seconds(false)
                //                 ->label('To')
                //                 ->reactive()
                //                 ->required(),
                //             ])
                //         ])->createItemButtonLabel('Add time')
                //     ])->reactive()->disableItemCreation(),
                // ])
                // ->action(function (array $data) {
                //     $dates_and_time = $this->mergeDateAndTime($data['schedule_dates']);
                //     foreach ($dates_and_time as $item) {
                //         EventSchedule::create([
                //             'event_id' => $this->record->id,
                //             'schedule_date' => $item['date'],
                //             'start_time' => $item['time_from'],
                //             'end_time' => $item['time_to'],
                //         ]);
                //     }
                // })->successNotificationTitle('Event Schedules Added')
            ])
            ->bulkActions([
                // ...
            ]);
    }


    public function loadData()
    {
        // Fetch the event details
        $this->event = Event::find($this->eventSchedule->event->id);
        if ($this->event) {
            // Fetch user attendance for the event schedule
            $this->users = Attendance::where('event_schedule_id', $this->eventSchedule->id)
                ->where('is_present', 1)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['latitude', 'longitude', 'user_id', 'in', 'out'])
                ->map(function ($attendance) {
                    return [
                        'latitude' => $attendance->latitude,
                        'longitude' => $attendance->longitude,
                        'name' => $attendance->user->name ?? 'Unknown',
                        'time_in' => $attendance->in,
                        'time_out' => $attendance->out,
                    ];
                });

        }
    }

    public function render()
    {
        return view('livewire.admin.view-attendance', [
            'event' => $this->event,
            'users' => $this->users,
        ]);
    }
}
