<?php

declare(strict_types=1);

namespace Tinoecom\Core;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Tinoecom\Core\Console\InstallCommand;
use Tinoecom\Core\Traits\HasRegisterConfigAndMigrationFiles;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class CoreServiceProvider extends PackageServiceProvider
{
    use HasRegisterConfigAndMigrationFiles;

    protected array $configFiles = [
        'core',
        'media',
        'models',
        'orders',
    ];

    protected string $root = __DIR__ . '/..';

    public function configurePackage(Package $package): void
    {
        $package
            ->name('tinoecom-core')
            ->hasTranslations()
            ->hasCommands([
                InstallCommand::class,
            ]);
    }

    public function packageBooted(): void
    {
        setlocale(LC_ALL, config('app.locale'));

        Carbon::setLocale(config('app.locale'));

        $this->bootModelRelationName();
    }

    public function packageRegistered(): void
    {
        $this->registerConfigFiles();
        $this->registerDatabase();
    }

    protected function bootModelRelationName(): void
    {
        Relation::morphMap([
            'brand' => config('tinoecom.models.brand'),
            'category' => config('tinoecom.models.category'),
            'collection' => config('tinoecom.models.collection'),
            'product' => config('tinoecom.models.product'),
            'variant' => config('tinoecom.models.variant'),
            'channel' => config('tinoecom.models.channel'),
        ]);
    }
}
