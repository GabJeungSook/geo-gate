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
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
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
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // EditAction::make()
                // ->label('Edit')
                // ->icon('heroicon-o-pencil')
                // ->color('success')
                // ->form([
                //     Select::make('campus_id')
                //     ->relationship('campus', 'name'),
                //     TextInput::make('course_code')
                //         ->required()
                //         ->maxLength(255),
                //     TextInput::make('course_description')
                //         ->required()
                //         ->maxLength(255),
                // ])->successNotificationTitle('Course Updated')
                
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
