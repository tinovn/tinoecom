<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Tinoecom\Components\Section;
use Tinoecom\Components\Separator;
use Tinoecom\Core\Models\Country;
use Tinoecom\Core\Models\Currency;
use Tinoecom\Core\Models\Setting;
use Tinoecom\Traits\SaveSettings;

/**
 * @property Form $form
 */
#[Layout('tinoecom::components.layouts.setting')]
class General extends Component implements HasForms
{
    use InteractsWithForms;
    use SaveSettings;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::query()->whereIn('key', [
            'name',
            'legal_name',
            'email',
            'about',
            'phone_number',
            'logo',
            'cover',
            'street_address',
            'postal_code',
            'city',
            'country_id',
            'default_currency_id',
            'currencies',
            'facebook_link',
            'instagram_link',
            'twitter_link',
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
                Section::make(__('tinoecom::pages/settings/global.general.store_details'))
                    ->description(__('tinoecom::pages/settings/global.general.store_detail_summary'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\TextInput::make('name')
                            ->label(__('tinoecom::forms.label.store_name'))
                            ->prefixIcon('untitledui-shop')
                            ->maxLength(100)
                            ->required(),
                        Components\Grid::make()
                            ->schema([
                                Components\TextInput::make('email')
                                    ->label(__('tinoecom::forms.label.email'))
                                    ->prefixIcon('untitledui-mail')
                                    ->helperText(__('tinoecom::pages/settings/global.general.email_helper'))
                                    ->autocomplete('email-address')
                                    ->email()
                                    ->required(),
                                Components\TextInput::make('phone_number')
                                    ->label(__('tinoecom::forms.label.phone_number'))
                                    ->tel()
                                    ->helperText(__('tinoecom::pages/settings/global.general.phone_number_helper')),
                            ]),
                    ]),
                Separator::make(),
                Section::make(__('tinoecom::pages/settings/global.general.assets'))
                    ->description(__('tinoecom::pages/settings/global.general.assets_summary'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\FileUpload::make('logo')
                            ->label(__('tinoecom::forms.label.logo'))
                            ->avatar()
                            ->image()
                            ->maxSize(1024)
                            ->disk(config('tinoecom.media.storage.collection_name')),
                        Components\FileUpload::make('cover')
                            ->label(__('tinoecom::forms.label.cover_photo'))
                            ->image()
                            ->maxSize(1024)
                            ->disk(config('tinoecom.media.storage.collection_name')),
                    ]),
                Separator::make(),
                Section::make(__('tinoecom::pages/settings/global.general.store_address'))
                    ->description(__('tinoecom::pages/settings/global.general.store_address_summary'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\TextInput::make('legal_name')
                            ->label(__('tinoecom::forms.label.legal_name'))
                            ->placeholder('ShopStation LLC')
                            ->required(),
                        Components\RichEditor::make('about')
                            ->label(__('tinoecom::forms.label.about'))
                            ->fileAttachmentsDisk(config('tinoecom.media.storage.disk_name'))
                            ->fileAttachmentsDirectory(config('tinoecom.media.storage.collection_name')),
                        Components\TextInput::make('street_address')
                            ->label(__('tinoecom::forms.label.street_address'))
                            ->placeholder('Akwa Avenue 34')
                            ->required(),
                        Components\Grid::make()->schema([
                            Components\TextInput::make('city')
                                ->label(__('tinoecom::forms.label.city'))
                                ->required(),
                            Components\TextInput::make('postal_code')
                                ->label(__('tinoecom::forms.label.postal_code'))
                                ->required(),
                        ]),
                        Components\Select::make('country_id')
                            ->label(__('tinoecom::forms.label.country'))
                            ->options(Country::query()->pluck('name', 'id'))
                            ->searchable(),
                    ]),
                Separator::make(),
                Section::make(__('tinoecom::pages/settings/global.general.store_currency'))
                    ->description(__('tinoecom::pages/onboarding.currency_description'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\Select::make('currencies')
                            ->label(__('tinoecom::forms.label.currencies'))
                            ->helperText(__('tinoecom::pages/onboarding.currencies_description'))
                            ->options(Currency::query()->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->multiple()
                            ->minItems(1)
                            ->required()
                            ->live()
                            ->native(false),
                        Components\Select::make('default_currency_id')
                            ->label(__('tinoecom::forms.label.default_currency'))
                            ->options(
                                fn (Get $get) => Currency::query()
                                    ->select('name', 'id')
                                    ->whereIn('id', $get('currencies'))
                                    ->pluck('name', 'id')
                            )
                            ->native(false)
                            ->required(),
                    ]),
                Separator::make(),
                Section::make(__('tinoecom::pages/settings/global.general.social_links'))
                    ->description(__('tinoecom::pages/settings/global.general.social_links_summary'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\TextInput::make('facebook_link')
                            ->prefix(
                                fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                    <x-tinoecom::icons.facebook
                                        class="h-5 w-5 text-gray-400 dark:text-gray-500"
                                        aria-hidden="true"
                                    />
                                Blade))
                            )
                            ->label(__('tinoecom::words.socials.facebook'))
                            ->placeholder('https://facebook.com/laraveltinoecom'),
                        Components\Grid::make()
                            ->schema([
                                Components\TextInput::make('instagram_link')
                                    ->prefix(
                                        fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                            <x-tinoecom::icons.instagram
                                                class="h-5 w-5 text-gray-400 dark:text-gray-500"
                                                aria-hidden="true"
                                            />
                                        Blade))
                                    )
                                    ->label(__('tinoecom::words.socials.instagram'))
                                    ->placeholder('https://instagram.com/laraveltinoecom'),
                                Components\TextInput::make('twitter_link')
                                    ->prefix(
                                        fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                            <x-tinoecom::icons.twitter
                                                class="h-5 w-5 text-gray-400 dark:text-gray-500"
                                                aria-hidden="true"
                                            />
                                        Blade))
                                    )
                                    ->label(__('tinoecom::words.socials.twitter'))
                                    ->placeholder('https://twitter.com/laraveltinoecom'),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(): void
    {
        $this->saveSettings($this->form->getState());

        Notification::make()
            ->title(__('tinoecom::notifications.store_info'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.general')
            ->title(__('tinoecom::pages/settings/global.general.title'));
    }
}
