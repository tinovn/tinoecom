<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Settings\Locations;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Tinoecom\Components\Form\AddressField;
use Tinoecom\Components\Section;
use Tinoecom\Components\Separator;
use Tinoecom\Core\Models\Inventory;

/**
 * @property Forms\Form $form
 */
class InventoryForm extends Component implements HasForms
{
    use InteractsWithForms;

    public Inventory $inventory;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->inventory->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('tinoecom::pages/settings/global.location.detail'))
                    ->description(__('tinoecom::pages/settings/global.location.detail_summary'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('tinoecom::forms.label.name'))
                            ->placeholder('White House')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set): void {
                                $set('code', Str::slug($state));
                            }),
                        Forms\Components\Hidden::make('code'),
                        Forms\Components\TextInput::make('email')
                            ->label(__('tinoecom::forms.label.email'))
                            ->autocomplete('email-address')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('tinoecom::forms.label.description'))
                            ->rows(3)
                            ->columnSpan('full'),
                        Forms\Components\Toggle::make('is_default')
                            ->label(__('tinoecom::pages/settings/global.location.set_default'))
                            ->helperText(__('tinoecom::pages/settings/global.location.set_default_summary'))
                            ->columnSpan('full'),
                    ])
                    ->columns(),
                Separator::make(),
                Section::make(__('tinoecom::pages/settings/global.location.address'))
                    ->description(__('tinoecom::pages/settings/global.location.address_summary'))
                    ->aside()
                    ->compact()
                    ->schema(AddressField::make())
                    ->columns(),
            ])
            ->statePath('data')
            ->model($this->inventory);
    }

    public function store(): void
    {
        if ($this->inventory->id) {
            $this->inventory->update($this->form->getState());
        } else {
            Inventory::query()->create($this->form->getState());
        }

        Notification::make()
            ->title(__('tinoecom::notifications.save', ['item' => __('tinoecom::pages/settings/global.location.single')]))
            ->success()
            ->send();

        $this->redirectRoute(name: 'tinoecom.settings.locations', navigate: true);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.settings.locations._form');
    }
}
