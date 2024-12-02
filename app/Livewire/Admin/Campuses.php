<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
use App\Models\Campus;

class Campuses extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Campus::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('latitude'),
                TextColumn::make('longitude'),
                TextColumn::make('radius'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('update_campus')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->color('success')
                ->url(fn (Campus $record): string => route('edit_campus', $record))
            ])
            ->headerActions([
                Action::make('add_campus')
                ->label('Add Campus')
                ->color('success')
                ->url(fn (): string => route('add_campus'))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.admin.campuses');
    }
}
