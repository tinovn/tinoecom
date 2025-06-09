<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Account;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Tinoecom\Components\Section;
use Tinoecom\Core\Models\User;
use Tinoecom\Traits\HasAuthenticated;

/**
 * @property Form $form
 */
class Profile extends Component implements HasForms
{
    use HasAuthenticated;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getUser()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('tinoecom::pages/auth.account.profile_title'))
                    ->description(__('tinoecom::pages/auth.account.profile_description'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\FileUpload::make('avatar_location')
                            ->label(__('tinoecom::forms.label.photo'))
                            ->avatar()
                            ->image()
                            ->maxSize(1024)
                            ->disk(config('tinoecom.media.storage.disk_name')),
                        Components\Grid::make()
                            ->schema([
                                Components\TextInput::make('first_name')
                                    ->label(__('tinoecom::forms.label.first_name'))
                                    ->required(),
                                Components\TextInput::make('last_name')
                                    ->label(__('tinoecom::forms.label.last_name'))
                                    ->required(),
                                Components\TextInput::make('email')
                                    ->label(__('tinoecom::forms.label.email'))
                                    ->prefixIcon('untitledui-mail')
                                    ->autocomplete('email-address')
                                    ->email()
                                    ->required()
                                    ->unique(
                                        table: config('auth.providers.users.model', User::class),
                                        ignorable: $this->getUser()
                                    ),
                                Components\TextInput::make('phone_number')
                                    ->label(__('tinoecom::forms.label.phone_number'))
                                    ->tel(),
                            ]),
                    ]),
            ])
            ->statePath('data')
            ->model($this->getUser());
    }

    public function save(): void
    {
        $this->getUser()
            ->update(
                array_merge(
                    $this->form->getState(),
                    filled($this->form->getState()['avatar_location'])
                        ? ['avatar_type' => 'storage']
                        : ['avatar_type' => 'avatar_ui']
                )
            );

        $this->dispatch('updated-profile');

        Notification::make()
            ->title(__('tinoecom::notifications.users_roles.profile_update'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.account.profile');
    }
}
