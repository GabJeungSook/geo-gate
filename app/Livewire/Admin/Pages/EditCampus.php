<?php

namespace App\Livewire\Admin\Pages;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;
use Livewire\Component;

class EditCampus extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $record;
    public $name;
    public $latitude;
    public $longitude;
    public $radius;

    public function mount($record)
    {
        $this->record = $record;
        $this->name = $record->name;
        $this->latitude = $record->latitude;
        $this->longitude = $record->longitude;
        $this->radius = $record->radius;
    }

    public function updateAction(): Action
    {
        return Action::make('update')
            ->requiresConfirmation()
            ->color('success')
            ->action(function () {
                $this->record->name = $this->name;
                $this->record->latitude = $this->latitude;
                $this->record->longitude = $this->longitude;
                $this->record->radius = $this->radius;
                $this->record->save();

                Notification::make()
                ->success()
                ->title('Success')
                ->body('The campus details are updated successfully.');

                return redirect()->route('campuses');
            });
    }

    public function render()
    {
        return view('livewire.admin.pages.edit-campus');
    }
}
