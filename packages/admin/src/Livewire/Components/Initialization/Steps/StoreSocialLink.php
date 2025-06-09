<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Initialization\Steps;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Tinoecom\Core\Models\Inventory;
use Tinoecom\Traits\SaveSettings;
use Spatie\LivewireWizard\Components\StepComponent;

/**
 * @property Forms\Form $form
 */
final class StoreSocialLink extends StepComponent implements HasForms
{
    use InteractsWithForms;
    use SaveSettings;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('facebook_link')
                    ->prefix(
                        fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                            <x-tinoecom::icons.facebook
                                class="size-5 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                        Blade))
                    )
                    ->label(__('tinoecom::words.socials.facebook'))
                    ->placeholder('https://facebook.com/laraveltinoecom'),

                Forms\Components\TextInput::make('instagram_link')
                    ->prefix(
                        fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                            <x-tinoecom::icons.instagram
                                class="size-5 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                        Blade))
                    )
                    ->label(__('tinoecom::words.socials.instagram'))
                    ->placeholder('https://instagram.com/laraveltinoecom'),

                Forms\Components\TextInput::make('twitter_link')
                    ->prefix(
                        fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                            <x-tinoecom::icons.twitter
                                class="size-5 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                        Blade))
                    )
                    ->label(__('tinoecom::words.socials.twitter'))
                    ->placeholder('https://twitter.com/laraveltinoecom'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->saveSettings($this->form->getState());

        $this->createDefaultInventory();

        Notification::make()
            ->title(__('tinoecom::notifications.store_info'))
            ->success()
            ->send();

        $this->redirectRoute('tinoecom.dashboard', navigate: true);
    }

    public function createDefaultInventory(): void
    {
        Inventory::query()->create([
            'name' => $name = tinoecom_setting('name'),
            'code' => Str::slug($name),
            'email' => tinoecom_setting('email'),
            'street_address' => tinoecom_setting('street_address'),
            'postal_code' => tinoecom_setting('postal_code'),
            'city' => tinoecom_setting('city'),
            'phone_number' => tinoecom_setting('phone_number'),
            'country_id' => tinoecom_setting('country_id'),
            'is_default' => true,
        ]);
    }

    public function stepInfo(): array
    {
        return [
            'label' => __('tinoecom::pages/onboarding.step_tree_title'),
            'complete' => false,
        ];
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.initialization.store-social-link');
    }
}
