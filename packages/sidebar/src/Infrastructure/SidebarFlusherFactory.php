<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Infrastructure;

use Illuminate\Support\Str;
use Tinoecom\Sidebar\Exceptions\SidebarFlusherNotSupported;

final class SidebarFlusherFactory
{
    public static function getClassName(string $name): string
    {
        if ($name) {
            $class = __NAMESPACE__ . '\\' . Str::studly($name) . 'SidebarFlusher';

            if (class_exists($class)) {
                return $class;
            }

            throw new SidebarFlusherNotSupported('Chosen caching type is not supported. Supported: [static, user-based]');
        }

        return __NAMESPACE__ . '\\NullSidebarFlusher';
    }
}
