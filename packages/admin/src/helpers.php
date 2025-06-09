<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Tinoecom\TinoecomPanel;

if (! function_exists('active')) {
    function active(array $routes, string $activeClass = 'active', string $defaultClass = '', bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], $routes) && $condition ? $activeClass : $defaultClass;
    }
}

if (! function_exists('is_active')) {
    function is_active(array $routes): bool
    {
        return (bool) call_user_func_array([app('router'), 'is'], $routes);
    }
}

if (! function_exists('get_asset_id')) {
    function get_asset_id(string $file, ?string $manifestPath = null): ?string
    {
        $manifestPath ??= __DIR__ . '/../public/mix-manifest.json';

        if (! file_exists($manifestPath)) {
            return null;
        }

        $manifest = json_decode(file_get_contents($manifestPath), associative: true);

        $file = "/{$file}";

        if (! array_key_exists($file, $manifest)) {
            return null;
        }

        $file = $manifest[$file];

        if (! str_contains($file, 'id=')) {
            return null;
        }

        return (string) Str::of($file)->after('id=');
    }
}

if (! function_exists('tinoecom')) {
    function tinoecom(): TinoecomPanel
    {
        /** @var TinoecomPanel $tinoecom */
        $tinoecom = app('tinoecom');

        return $tinoecom;
    }
}

if (! function_exists('tinoecom_fallback_url')) {
    function tinoecom_fallback_url(): string
    {
        return tinoecom_panel_assets('/images/placeholder.jpg');
    }
}

if (! function_exists('tinoecom_panel_asset')) {
    function tinoecom_panel_assets(string $asset): string
    {
        return url(tinoecom()->prefix() . $asset);
    }
}
