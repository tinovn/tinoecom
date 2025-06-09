<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Settings\Team;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Tinoecom\Core\Models\Role;
use Tinoecom\Core\Repositories\UserRepository;

class UsersRole extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Role $role;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                (new UserRepository)
                    ->with('roles')
                    ->query()
                    ->whereHas('roles', function (Builder $query): void {
                        $query->where('name', $this->role->name);
                    })
            )
            ->columns([
                Tables\Columns\ViewColumn::make('full_name')
                    ->label(__('tinoecom::forms.label.full_name'))
                    ->view('tinoecom::livewire.tables.cells.administrators.name'),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('tinoecom::forms.label.email'))
                    ->icon(fn ($record): string => $record->email_verified_at ? 'untitledui-check-verified-02' : 'untitledui-alert-circle')
                    ->iconColor(fn ($record): string => $record->email_verified_at ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('roles_label')
                    ->label(__('tinoecom::forms.label.role'))
                    ->badge(),

                Tables\Columns\TextColumn::make('id')
                    ->label(__('tinoecom::forms.label.access'))
                    ->color('gray')
                    ->formatStateUsing(
                        fn ($record) => $record->hasRole(config('tinoecom.core.users.admin_role'))
                        ? __('tinoecom::words.full')
                        : __('tinoecom::words.limited')
                    ),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make('delete')
                    ->label(__('tinoecom::forms.actions.delete'))
                    ->visible(fn ($record) => tinoecom()->auth()->user()->isAdmin() && ! $record->isAdmin()) // @phpstan-ignore-line
                    ->successNotificationTitle(__('tinoecom::notifications.users_roles.admin_deleted')),
            ])
            ->emptyStateIcon('untitledui-users')
            ->emptyStateHeading(__('tinoecom::words.no_users'));
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.settings.team.users-role');
    }
}
