<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\Role;
use Tinoecom\Livewire\Components\ModalComponent;

/**
 * @property Form $form
 */
class CreateRole extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('tinoecom::modals.roles.labels.name'))
                    ->placeholder('manager')
                    ->unique(table: Role::class, column: 'name')
                    ->required(),

                Forms\Components\TextInput::make('display_name')
                    ->label(__('tinoecom::forms.label.display_name'))
                    ->placeholder('Manager'),

                Forms\Components\Textarea::make('description')
                    ->label(__('tinoecom::forms.label.description'))
                    ->rows(3)
                    ->columnSpan('full'),
            ])
            ->columns()
            ->statePath('data');
    }

    public function save(): void
    {
        Role::create($this->form->getState());

        $this->dispatch('teamUpdate');

        Notification::make()
            ->title(__('tinoecom::notifications.users_roles.role_added'))
            ->success()
            ->send();

        $this->closeModal();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.create-role');
    }
}
