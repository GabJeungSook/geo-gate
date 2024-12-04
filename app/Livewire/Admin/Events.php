<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use App\Models\Event;


class Events extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Event::query())
            ->columns([
                TextColumn::make('event_description')->label('Description')->searchable()->sortable(),
                TextColumn::make('campus.name')->searchable()->sortable(),
                TextColumn::make('start_date')
                ->formatStateUsing(fn ($record) => Carbon::parse($record->start_date)->format('F d, Y'))->sortable(),
                TextColumn::make('end_date')
                ->formatStateUsing(fn ($record) => Carbon::parse($record->end_date)->format('F d, Y'))->sortable(),
                ToggleColumn::make('is_active')->label('Active')
                ->updateStateUsing(function ($record, $state) {
                    $active = Event::where('is_active', true)->exists();
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
                Action::make('view_details')
                ->label('View Details')
                ->icon('heroicon-o-eye')
                ->button()
                ->color('warning')
                ->url(fn (Event $record): string => route('event_details', $record))
                ->visible(fn (Event $record) => $record->is_active)
                
            ])
            ->headerActions([
                CreateAction::make()
                ->label('Add Event')
                ->color('success')
                ->model(Event::class)
                ->form([
                    Select::make('campus_id')
                    ->label('Campus')
                    ->relationship('campus', 'name'),
                    TextInput::make('event_description')
                        ->label('Description')
                        ->required()
                        ->maxLength(255),
                    DatePicker::make('start_date')
                    ->native(false),
                    DatePicker::make('end_date')
                    ->native(false),
                    // ...
                ])->successNotificationTitle('Event Added')
            ])
            ->bulkActions([
                // ...
            ]);
    }
    
    public function render()
    {
        return view('livewire.admin.events');
    }
}
