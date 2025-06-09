<?php

declare(strict_types=1);

namespace Tinoecom\Core\Traits;

trait HasRegisterConfigAndMigrationFiles
{
    public function registerConfigFiles(): void
    {
        collect($this->configFiles)->each(function ($config): void {
            $this->mergeConfigFrom($this->root . "/config/{$config}.php", "tinoecom.{$config}");
            $this->publishes([$this->root . "/config/{$config}.php" => config_path("tinoecom/{$config}.php")], 'tinoecom-config');
        });
    }

    public function registerDatabase(): void
    {
        if (! file_exists($this->root . '/database')) {
            return;
        }

        $this->loadMigrationsFrom($this->root . '/database/migrations');
    }
}
