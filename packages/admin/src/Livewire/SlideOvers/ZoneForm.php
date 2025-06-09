<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Tinoecom\Components\Separator;
use Tinoecom\Contracts\SlideOverForm;
use Tinoecom\Core\Models\Carrier;
use Tinoecom\Core\Models\Country;
use Tinoecom\Core\Models\Currency;
use Tinoecom\Core\Models\PaymentMethod;
use Tinoecom\Core\Models\Zone;
use Tinoecom\Livewire\Components\SlideOverComponent;
use Tinoecom\Traits\InteractsWithSlideOverForm;

/**
 * @property Forms\Form $form
 */
class ZoneForm extends SlideOverComponent implements HasForms, SlideOverForm
{
    use InteractsWithForms;
    use InteractsWithSlideOverForm;

    public ?Zone $zone = null;

    public string $action = 'store';

    public ?string $title = null;

    public ?string $description = null;

    public ?array $data = [];

    public array $countriesInZone = [];

    public function mount(?int $zoneId = null): void
    {
        $this->zone = $zoneId
            ? Zone::with(['countries', 'paymentMethods', 'carriers'])->find($zoneId)
            : new Zone;

        $this->title = $zoneId
            ? $this->zone->name
            : __('tinoecom::pages/settings/zones.add_action');

        $this->countriesInZone = Country::query()
            ->whereHas('zones')
            ->pluck('id')
            ->toArray();

        $countries = $this->zone->countries()->pluck('id')->all();
        $payments = $this->zone->paymentMethods()->pluck('id')->all();
        $carriers = $this->zone->carriers()->pluck('id')->all();

        $this->form->fill(array_merge(
            $this->zone->toArray(),
            ['countries' => $countries],
            ['payments' => $payments],
            ['carriers' => $carriers],
        ));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('tinoecom::forms.label.name'))
                            ->placeholder('Africa')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set): void {
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\Hidden::make('slug'),

                        Forms\Components\TextInput::make('code')
                            ->label(__('tinoecom::forms.label.code'))
                            ->placeholder('AF'),
                    ]),

                Forms\Components\Select::make('countries')
                    ->label(__('tinoecom::forms.label.countries'))
                    ->placeholder(__('tinoecom::forms.placeholder.select_countries'))
                    ->multiple()
                    ->required()
                    ->options(
                        Country::query()
                            ->select('name', 'id')
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->disableOptionWhen(
                        fn (int $value): bool => in_array($value, $this->countriesInZone)
                    )
                    ->native(false),

                Forms\Components\Select::make('currency_id')
                    ->label(__('tinoecom::forms.label.currency'))
                    ->placeholder(__('tinoecom::forms.placeholder.choose_currency'))
                    ->helperText(__('tinoecom::pages/settings/zones.currency_help'))
                    ->options(
                        Currency::query()
                            ->whereIn('id', tinoecom_setting('currencies', false))
                            ->pluck('name', 'id')
                    )
                    ->native(false)
                    ->required(),

                Forms\Components\Toggle::make('is_enabled')
                    ->label(__('tinoecom::forms.label.visibility'))
                    ->helperText(__('tinoecom::words.set_visibility', ['name' => mb_strtolower(__('tinoecom::pages/settings/menu.zone'))])),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Placeholder::make('providers')
                            ->label(__('tinoecom::pages/settings/zones.providers'))
                            ->content(new HtmlString(Blade::render(<<<'Blade'
                                <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                                    {{ __('tinoecom::pages/settings/zones.providers_description') }}
                                </p>
                            Blade))),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('payments')
                                    ->label(__('tinoecom::pages/settings/payments.title'))
                                    ->options(PaymentMethod::query()->pluck('title', 'id'))
                                    ->searchable()
                                    ->multiple()
                                    ->required(),

                                Forms\Components\Select::make('carriers')
                                    ->label(__('tinoecom::pages/settings/carriers.title'))
                                    ->options(Carrier::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->multiple()
                                    ->required(),
                            ]),
                    ]),

                Separator::make(),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Metadata')
                    ->reorderable(),
            ])
            ->statePath('data')
            ->model($this->zone);
    }

    public function store(): void
    {
        $data = $this->form->getState();
        $validInputs = Arr::except($data, ['countries', 'payments', 'carriers']);

        if ($this->zone->id) {
            $this->zone->update($validInputs);
        } else {
            $this->zone = Zone::query()->create($validInputs);
        }

        if (array_key_exists('countries', $data)) {
            $this->zone->countries()->sync($data['countries']);
        }

        $this->zone->carriers()->sync($data['carriers']);
        $this->zone->paymentMethods()->sync($data['payments']);

        Notification::make()
            ->title(__('tinoecom::notifications.save', ['item' => $this->zone->name]))
            ->success()
            ->send();

        $this->redirectRoute('tinoecom.settings.zones', ['zone' => $this->zone->id]);
    }

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }
}
