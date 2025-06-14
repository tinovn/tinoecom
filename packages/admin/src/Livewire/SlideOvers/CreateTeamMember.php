<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tinoecom\Components\Form\GenderField;
use Tinoecom\Components\Section;
use Tinoecom\Core\Models\Role;
use Tinoecom\Core\Models\User;
use Tinoecom\Core\Repositories\UserRepository;
use Tinoecom\Livewire\Components\SlideOverComponent;
use Tinoecom\Notifications\AdminSendCredentials;

/**
 * @property Form $form
 */
class CreateTeamMember extends SlideOverComponent implements HasForms
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
                Section::make(__('tinoecom::pages/settings/staff.login_information'))
                    ->description(__('tinoecom::pages/settings/staff.login_information_summary'))
                    ->schema([
                        Components\TextInput::make('email')
                            ->label(__('tinoecom::forms.label.email'))
                            ->email()
                            ->required(),
                        Components\TextInput::make('password')
                            ->label(__('tinoecom::forms.label.password'))
                            ->password()
                            ->revealable()
                            ->required()
                            ->hintAction(
                                Components\Actions\Action::make(__('tinoecom::words.generate'))
                                    ->color('info')
                                    ->action(function (Set $set): void {
                                        $set('password', Str::password(16));
                                    }),
                            ),
                        Components\Toggle::make('send_mail')
                            ->label(__('tinoecom::pages/settings/staff.send_invite'))
                            ->helperText(__('tinoecom::pages/settings/staff.send_invite_summary')),
                    ]),
                Section::make(__('tinoecom::pages/settings/staff.personal_information'))
                    ->description(__('tinoecom::pages/settings/staff.personal_information_summary'))
                    ->schema([
                        Components\TextInput::make('first_name')
                            ->label(__('tinoecom::forms.label.first_name'))
                            ->required(),
                        Components\TextInput::make('last_name')
                            ->label(__('tinoecom::forms.label.last_name'))
                            ->required(),
                        GenderField::make(),
                        Components\TextInput::make('phone_number')
                            ->label(__('tinoecom::forms.label.phone_number'))
                            ->tel(),
                    ]),
                Section::make(__('tinoecom::pages/settings/staff.role_information'))
                    ->description(__('tinoecom::pages/settings/staff.role_information_summary'))
                    ->schema([
                        Components\Radio::make('role_id')
                            ->label(__('tinoecom::pages/settings/staff.choose_role'))
                            ->options(
                                Role::query()
                                    ->where('name', '<>', config('tinoecom.core.users.default_role'))
                                    ->pluck('display_name', 'id')
                            )
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(): void
    {
        $data = $this->form->getState();

        /** @var User $user */
        $user = (new UserRepository)->create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => Hash::make(
                value: $data['password']
            ),
            'phone_number' => $data['first_name'],
            'gender' => $data['gender'],
            'email_verified_at' => now()->toDateTimeString(),
        ]);

        /** @var Role $role */
        $role = Role::findById((int) $data['role_id']);

        $user->assignRole([$role->name]);

        $this->dispatch('teamUpdate');

        if ($data['send_mail']) {
            $user->notify(new AdminSendCredentials($data['password']));
        }

        Notification::make()
            ->body(__('tinoecom::notifications.create', ['item' => $user->full_name]))
            ->success()
            ->send();

        $this->dispatch('closePanel');
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.create-team-member');
    }
}
