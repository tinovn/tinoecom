<?php

declare(strict_types=1);

namespace Tinoecom;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Tinoecom\Events\LoadTinoecom;

final class TinoecomPanel
{
    protected bool $isServing = false;

    protected string | Htmlable | null $theme = null;

    public function auth(): Guard
    {
        return auth()->guard(config('tinoecom.auth.guard'));
    }

    public function prefix(): string
    {
        return config('tinoecom.admin.prefix');
    }

    public function registerTheme(string | Htmlable | null $theme): void
    {
        $this->theme = $theme;
    }

    public function registerViteTheme(string | array $theme, ?string $buildDirectory = null): void
    {
        $this->theme = app(Vite::class)($theme, $buildDirectory);
    }

    public function getThemeLink(): Htmlable
    {
        if (Str::of($this->theme)->contains('<link')) {
            return $this->theme instanceof Htmlable ? $this->theme : new HtmlString($this->theme);
        }

        $url = $this->theme ?? route('tinoecom.asset', [
            'id' => get_asset_id('tinoecom.css'),
            'file' => 'tinoecom.css',
        ]);

        return new HtmlString("<link rel=\"stylesheet\" href=\"{$url}\" />");
    }

    public function setServingStatus(bool $condition = true): void
    {
        $this->isServing = $condition;
    }

    public function isServing(): bool
    {
        return $this->isServing;
    }

    public function serving(Closure $callback): void
    {
        Event::listen(LoadTinoecom::class, $callback);
    }

    public function version(): string
    {
        return '2.x';
    }
}
