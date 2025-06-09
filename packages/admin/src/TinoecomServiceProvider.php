<?php

declare(strict_types=1);

namespace Tinoecom;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;
use Tinoecom\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;
use Tinoecom\Contracts\LoginResponse as LoginResponseContract;
use Tinoecom\Contracts\TwoFactorAuthenticationProvider as TwoFactorAuthenticationProviderContract;
use Tinoecom\Contracts\TwoFactorDisabledResponse as TwoFactorDisabledResponseContract;
use Tinoecom\Contracts\TwoFactorEnabledResponse as TwoFactorEnabledResponseContract;
use Tinoecom\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Tinoecom\Core\Traits\HasRegisterConfigAndMigrationFiles;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Http\Middleware\Authenticate;
use Tinoecom\Http\Middleware\DispatchTinoecom;
use Tinoecom\Http\Responses\FailedTwoFactorLoginResponse;
use Tinoecom\Http\Responses\LoginResponse;
use Tinoecom\Http\Responses\TwoFactorDisabledResponse;
use Tinoecom\Http\Responses\TwoFactorEnabledResponse;
use Tinoecom\Http\Responses\TwoFactorLoginResponse;
use Tinoecom\Livewire\Components;
use Tinoecom\Livewire\Pages;
use Tinoecom\Providers\FeatureServiceProvider;
use Tinoecom\Providers\SidebarServiceProvider;
use Tinoecom\Providers\TwoFactorAuthenticationProvider;
use Tinoecom\Traits\LoadComponents;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class TinoecomServiceProvider extends PackageServiceProvider
{
    use HasRegisterConfigAndMigrationFiles;
    use LoadComponents;

    protected array $configFiles = [
        'admin',
        'auth',
        'features',
        'routes',
        'settings',
    ];

    protected array $componentsConfig = ['account', 'dashboard', 'setting'];

    protected string $root = __DIR__ . '/..';

    public function configurePackage(Package $package): void
    {
        $package
            ->name('tinoecom')
            ->hasTranslations()
            ->hasViewComponents('tinoecom')
            ->hasRoute('web')
            ->hasCommands([
                Console\ComponentPublishCommand::class,
                Console\InstallCommand::class,
                Console\PublishCommand::class,
                Console\MakePageCommand::class,
                Console\MakeTinoecomPageCommand::class,
                Console\SymlinkCommand::class,
                Console\UserCommand::class,
            ]);
    }

    public function packageBooted(): void
    {
        $this->bootLivewireComponents();

        FilamentColor::register([
            'primary' => config('tinoecom.admin.filament_color'),
            'teal' => Color::Teal,
            'green' => Color::Green,
            'sky' => Color::Sky,
            'indigo' => Color::Indigo,
            'info' => Color::Cyan,
        ]);

        Tinoecom::serving(function (): void {
            Tinoecom::setServingStatus();
        });
    }

    public function packageRegistered(): void
    {
        $this->registerConfigFiles();
        $this->registerComponentsConfigFiles();
        $this->registerResponseBindings();

        $this->app->singleton(
            TwoFactorAuthenticationProviderContract::class,
            fn ($app) => new TwoFactorAuthenticationProvider($app->make(Google2FA::class))
        );

        $this->app->bind(LoginResponseContract::class, LoginResponse::class);

        $this->app->register(SidebarServiceProvider::class);
        $this->app->register(FeatureServiceProvider::class);

        $this->app->scoped('tinoecom', fn (): TinoecomPanel => new TinoecomPanel);

        $this->loadViewsFrom($this->root . '/resources/views', 'tinoecom');
    }

    public function bootingPackage(): void
    {
        TextColumn::macro('currency', function (string | Closure | null $currency = null): TextColumn {
            /*** @var TextColumn $this */
            // @phpstan-ignore-next-line
            $this->formatStateUsing(static function (Column $column, $state) use ($currency): ?string {
                if (blank($state)) {
                    return null;
                }

                if (blank($currency)) {
                    $currency = tinoecom_currency();
                }

                return tinoecom_money_format(
                    amount: $state,
                    currency: mb_strtoupper($column->evaluate($currency)),
                );
            });

            return $this; // @phpstan-ignore-line
        });

        TextInput::macro('currencyMask', function ($thousandSeparator = ',', $decimalSeparator = '.', $precision = 2): TextInput {
            $this->view = 'tinoecom::components.filament.forms.currency-mask'; // @phpstan-ignore-line
            $this->viewData(compact('thousandSeparator', 'decimalSeparator', 'precision')); // @phpstan-ignore-line

            return $this; // @phpstan-ignore-line
        });
    }

    protected function bootLivewireComponents(): void
    {
        Livewire::addPersistentMiddleware([
            Authenticate::class,
            DispatchTinoecom::class,
        ]);

        foreach (array_merge(
            $this->getLivewireComponents(),
            $this->loadLivewireComponents('account'),
            $this->loadLivewireComponents('dashboard'),
            $this->loadLivewireComponents('setting'),
        ) as $alias => $component) {
            Livewire::component("tinoecom-{$alias}", $component);
        }
    }

    protected function getLivewireComponents(): array
    {
        return [
            'auth.login' => Pages\Auth\Login::class,
            'auth.password' => Pages\Auth\ForgotPassword::class,
            'auth.password-reset' => Pages\Auth\ResetPassword::class,
            'initialize' => Pages\Initialization::class,
            'initialize-wizard' => Components\Initialization\InitializationWizard::class,
            'initialize-store-information' => Components\Initialization\Steps\StoreInformation::class,
            'initialize-store-address' => Components\Initialization\Steps\StoreAddress::class,
            'initialize-store-social-link' => Components\Initialization\Steps\StoreSocialLink::class,
            'products.attributes.multiple-choice' => Components\Products\Attributes\MultipleChoice::class,
            'products.attributes.single-choice' => Components\Products\Attributes\SingleChoice::class,
            'products.attributes.text' => Components\Products\Attributes\Text::class,
        ];
    }

    protected function registerResponseBindings(): void
    {
        $this->app->singleton(FailedTwoFactorLoginResponseContract::class, FailedTwoFactorLoginResponse::class);
        $this->app->singleton(TwoFactorDisabledResponseContract::class, TwoFactorDisabledResponse::class);
        $this->app->singleton(TwoFactorEnabledResponseContract::class, TwoFactorEnabledResponse::class);
        $this->app->singleton(TwoFactorLoginResponseContract::class, TwoFactorLoginResponse::class);
    }
}
