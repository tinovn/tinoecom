<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Initialization\Steps;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\Country;
use Tinoecom\Core\Models\Currency;
use Tinoecom\Core\Models\Setting;
use Tinoecom\Traits\SaveSettings;
use Spatie\LivewireWizard\Components\StepComponent;

/**
 * @property Forms\Form $form
 */
final class StoreInformation extends StepComponent implements HasForms
{
    use InteractsWithForms;
    use SaveSettings;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::query()->whereIn('key', [
            'name',
            'email',
            'about',
            'country_id',
            'default_currency_id',
            'currencies',
        ])
            ->select('value', 'key')
            ->get();

        $this->form->fill(
            $settings->mapWithKeys(
                fn (Setting $item) => [$item['key'] => $item['value']]
            )->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('tinoecom::forms.label.store_name'))
                            ->prefixIcon('untitledui-shop')
                            ->maxLength(100)
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label(__('tinoecom::forms.label.email'))
                            ->prefixIcon('untitledui-mail')
                            ->autocomplete('email-address')
                            ->placeholder('your@laravel.store')
                            ->email()
                            ->required(),
                    ]),

                Forms\Components\Select::make('country_id')
                    ->label(__('tinoecom::forms.label.country'))
                    ->options(
                        Country::query()
                            ->select('name', 'id', 'region', 'cca2')
                            ->orderBy('name')
                            ->get()
                            ->sortBy('region')
                            ->groupBy('region')
                            ->map(fn ($region): array => $region->pluck('name', 'id')->toArray())
                    )
                    ->searchable()
                    ->native(false),

                Forms\Components\Select::make('currencies')
                    ->label(__('tinoecom::forms.label.currencies'))
                    ->helperText(__('tinoecom::pages/onboarding.currencies_description'))
                    ->options(Currency::query()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->multiple()
                    ->minItems(1)
                    ->required()
                    ->live()
                    ->native(false),

                Forms\Components\Select::make('default_currency_id')
                    ->label(__('tinoecom::forms.label.default_currency'))
                    ->helperText(__('tinoecom::pages/onboarding.currency_description'))
                    ->placeholder(__('tinoecom::forms.placeholder.select_currencies'))
                    ->options(
                        fn (Forms\Get $get) => Currency::query()
                            ->select('name', 'id')
                            ->whereIn('id', $get('currencies'))
                            ->pluck('name', 'id')
                    )
                    ->native(false)
                    ->required(),

                Forms\Components\Textarea::make('about')
                    ->label(__('tinoecom::forms.label.about'))
                    ->helperText(__('tinoecom::pages/onboarding.about_description'))
                    ->rows(3),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->saveSettings($this->form->getState());

        $this->nextStep();

        Notification::make()
            ->title(__('tinoecom::notifications.store_info'))
            ->success()
            ->send();
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('tinoecom::pages/onboarding.step_one_title'),
            'complete' => tinoecom_setting('name')
                && tinoecom_setting('email')
                && tinoecom_setting('country_id'),
        ];
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.initialization.store-information');
    }
}
