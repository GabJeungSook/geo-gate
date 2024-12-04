<?php

namespace App\Livewire\Admin\Pages;

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
use App\Models\Campus;
use App\Models\EventSchedule;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use Livewire\Component;


class EventDetails extends Component implements HasForms, HasTable 
{
    use InteractsWithTable;
    use InteractsWithForms;
    public $record;
    public $days;
    public $schedule_dates = [];
    public $data;
    
    public function mount($record)
    {
        $this->record = $record;
        $dates = $this->getDateRange($this->record->start_date, $this->record->end_date);
        $this->schedule_dates = $dates;
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(EventSchedule::query()->where('event_id', $this->record->id))
            ->columns([
                TextColumn::make('event.event_description'),
                TextColumn::make('schedule_date')->formatStateUsing(fn ($record) => Carbon::parse($record->schedule_date)->format('F d, Y')),
                TextColumn::make('start_time')->formatStateUsing(fn ($record) => Carbon::parse($record->start_time)->format('h:i A')),
                TextColumn::make('end_time')->formatStateUsing(fn ($record) => Carbon::parse($record->end_time)->format('h:i A')),
                ToggleColumn::make('is_active')->label('Active')
                ->updateStateUsing(function ($record, $state) {
                    $active = EventSchedule::where('is_active', true)->exists();
                    if($record->is_active)
                    {
                        $record->update(['is_active' => false]);
                    }else{
                        if($active)
                        {
                            Notification::make()
                            ->title('Operation Failed')
                            ->body('You can only activate one (1) schedule at a time.')
                            ->danger()
                            ->send();
                        } else {
                            $record->is_active == false ? $record->update(['is_active' => true]) : $record->update(['is_active' => false]);
                        }
                    }
                }),
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
                Action::make('add_schedule')
                ->label('Add Schedule')
                ->color('success')
                ->mountUsing(function (Form $form) {
                    $form->fill([
                        'schedule_dates' => $this->schedule_dates,
                    ]);
                })
                ->form([
                    Repeater::make('schedule_dates')
                    ->label('')
                    ->schema([
                        DatePicker::make('date')
                        ->native(false)
                        ->disabled()
                        ->reactive()
                        ->required(),
                        Repeater::make('time')
                        ->schema([
                            Grid::make(2)
                            ->schema([
                                TimePicker::make('time_from')
                                ->seconds(false)
                                ->label('From')
                                ->reactive()
                                ->required(),
                                TimePicker::make('time_to')
                                ->seconds(false)
                                ->label('To')
                                ->reactive()
                                ->required(),
                            ])
                        ])->createItemButtonLabel('Add time')
                    ])->reactive()->disableItemCreation(),
                ])
                ->action(function (array $data) {
                    $dates_and_time = $this->mergeDateAndTime($data['schedule_dates']);
                    foreach ($dates_and_time as $item) {
                        EventSchedule::create([
                            'event_id' => $this->record->id,
                            'schedule_date' => $item['date'],
                            'start_time' => $item['time_from'],
                            'end_time' => $item['time_to'],
                        ]);
                    }
                })->successNotificationTitle('Event Schedules Added')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function mergeDateAndTime($date_and_time)
    {
        $result = [];
    
        foreach ($this->schedule_dates as $date) {
            foreach ($date_and_time as $item) {
                if (isset($item['time'])) {
                    foreach ($item['time'] as $time) {
                        $result[] = [
                            'date' => $date["date"],
                            'time_from' => $time['time_from'] ?? null,
                            'time_to' => $time['time_to'] ?? null,
                        ];
                    }
                }
            }
        }
    
        return $result;
    }
    


    protected function getFormStatePath(): string
    {
        return 'data';
    }


    function getDateRange($startDate, $endDate) {
        $dates = [];
        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        while ($currentDate <= $endDate) {
            $dates[] = ['date' => date('Y-m-d', $currentDate)];
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }

    public function render()
    {
        return view('livewire.admin.pages.event-details');
    }
}
