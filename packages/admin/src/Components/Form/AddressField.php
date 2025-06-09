<?php

declare(strict_types=1);

namespace Tinoecom\Components\Form;

use Filament\Forms\Components;
use Tinoecom\Core\Models\Country;

final class AddressField
{
    public static function getPrefix(?string $prefix = null): ?string
    {
        if (! $prefix) {
            return null;
        }

        return $prefix . '.';
    }

    public static function make(?string $prefix = null): array
    {
        return [
            Components\TextInput::make(self::getPrefix($prefix) . 'street_address')
                ->label(__('tinoecom::forms.label.street_address'))
                ->placeholder('Akwa Avenue 34...')
                ->columnSpan('full')
                ->required(),
            Components\TextInput::make(self::getPrefix($prefix) . 'street_address_plus')
                ->label(__('tinoecom::forms.label.street_address_plus'))
                ->columnSpan('full'),
            Components\TextInput::make(self::getPrefix($prefix) . 'city')
                ->label(__('tinoecom::forms.label.city'))
                ->required(),
            Components\TextInput::make(self::getPrefix($prefix) . 'postal_code')
                ->label(__('tinoecom::forms.label.postal_code'))
                ->required(),
            Components\Select::make(self::getPrefix($prefix) . 'country_id')
                ->label(__('tinoecom::forms.label.country'))
                ->options(Country::query()->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->columnSpan('full'),
            Components\TextInput::make(self::getPrefix($prefix) . 'phone_number')
                ->label(__('tinoecom::forms.label.phone_number'))
                ->tel()
                ->columnSpan('full'),
        ];
    }
}
