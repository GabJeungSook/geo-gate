<?php

namespace App\Livewire\Admin\Pages;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;
use App\Models\Campus;

use Livewire\Component;

class AddCampus extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $name;
    public $latitude;
    public $longitude;
    public $radius;

    public function saveAction(): Action
    {
        return Action::make('save')
            ->requiresConfirmation()
            ->color('success')
            ->action(function () {
                Campus::create([
                    'name' => $this->name,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'radius' => $this->radius
                ]);

                Notification::make()
                ->success()
                ->title('Success')
                ->body('The campus details are saved successfully.');

                return redirect()->route('campuses');
            });
    }

    public function render()
    {
        return view('livewire.admin.pages.add-campus');
    }
}
