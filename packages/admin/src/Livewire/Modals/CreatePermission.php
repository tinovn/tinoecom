<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\Permission;
use Tinoecom\Core\Models\Role;
use Tinoecom\Livewire\Components\ModalComponent;

/**
 * @property Form $form
 */
class CreatePermission extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public int $roleId;

    public ?array $data = [];

    public function mount(int $id): void
    {
        $this->roleId = $id;

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('group_name')
                    ->label(__('tinoecom::forms.label.group_name'))
                    ->options(Permission::groups())
                    ->native(false)
                    ->columnSpan('full'),

                Forms\Components\TextInput::make('name')
                    ->label(__('tinoecom::modals.permissions.labels.name'))
                    ->placeholder('create_post, manage_articles, etc')
                    ->unique(table: Permission::class, column: 'name')
                    ->maxLength(30)
                    ->required(),

                Forms\Components\TextInput::make('display_name')
                    ->label(__('tinoecom::forms.label.display_name'))
                    ->placeholder('Create Blog posts')
                    ->maxLength(75)
                    ->required(),

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
        /** @var Permission $permission */
        $permission = Permission::query()->create($this->form->getState());

        Role::findById($this->roleId)->givePermissionTo($permission->name);

        Notification::make()
            ->title(__('tinoecom::notifications.users_roles.permission_add'))
            ->success()
            ->send();

        $this->dispatch('permissionAdded');

        $this->closeModal();
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.create-permission');
    }
}
