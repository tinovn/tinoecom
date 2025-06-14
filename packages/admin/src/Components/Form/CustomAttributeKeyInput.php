<?php

declare(strict_types=1);

namespace Tinoecom\Components\Form;

use Filament\Forms\Components;
use Filament\Support\Components\Component;
use Tinoecom\Core\Enum\FieldType;

final class CustomAttributeKeyInput
{
    public static function make(string $key, FieldType $type): Component
    {
        return match ($type) {
            FieldType::ColorPicker => Components\ColorPicker::make($key)
                ->default('#1E3A8A'),
            default => Components\TextInput::make($key)
        };
    }
}
