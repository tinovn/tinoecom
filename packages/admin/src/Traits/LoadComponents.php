<?php

declare(strict_types=1);

namespace Tinoecom\Traits;

trait LoadComponents
{
    public function loadLivewireComponents(string $feature): array
    {
        return array_merge(
            (array) config("tinoecom.components.{$feature}.pages"),
            (array) config("tinoecom.components.{$feature}.components")
        );
    }

    public function registerComponentsConfigFiles(): void
    {
        collect($this->componentsConfig)->each(function ($config): void {
            $this->mergeConfigFrom(
                path: $this->root . "/config/components/{$config}.php",
                key: "tinoecom.components.{$config}"
            );
        });
    }
}
