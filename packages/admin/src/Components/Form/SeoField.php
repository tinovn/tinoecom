<?php

declare(strict_types=1);

namespace Tinoecom\Components\Form;

use Filament\Forms;

final class SeoField
{
    /**
     * @return array<array-key, Forms\Components\Field>
     */
    public static function make(): array
    {
        return [
            Forms\Components\TextInput::make('seo_title')
                ->label(__('tinoecom::forms.label.title')),
            Forms\Components\Textarea::make('seo_description')
                ->label(__('tinoecom::forms.label.description'))
                ->hint(__('tinoecom::words.seo.characters'))
                ->maxLength(160),
        ];
    }
}
