<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
use App\Models\Course;

class Courses extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Course::query())
            ->columns([
                TextColumn::make('campus.name')->searchable()->sortable(),
                TextColumn::make('course_code')->searchable()->sortable(),
                TextColumn::make('course_description')->searchable()->sortable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->color('success')
                ->form([
                    Select::make('campus_id')
                    ->relationship('campus', 'name'),
                    TextInput::make('course_code')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('course_description')
                        ->required()
                        ->maxLength(255),
                ])->successNotificationTitle('Course Updated')
                
            ])
            ->headerActions([
                CreateAction::make()
                ->label('Add Course')
                ->color('success')
                ->model(Course::class)
                ->form([
                    Select::make('campus_id')
                    ->label('Campus')
                    ->relationship('campus', 'name'),
                    TextInput::make('course_code')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('course_description')
                        ->required()
                        ->maxLength(255),
                    // ...
                ])->successNotificationTitle('Course Added')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.admin.courses');
    }
}
