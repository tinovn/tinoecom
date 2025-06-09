<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Checkbox()
 * @method static string ColorPicker()
 * @method static string DatePicker()
 * @method static string RichText()
 * @method static string Select()
 * @method static string Text()
 * @method static string Number()
 */
enum FieldType: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Checkbox = 'checkbox';

    case ColorPicker = 'colorpicker';

    case DatePicker = 'datepicker';

    case RichText = 'richtext';

    case Select = 'select';

    case Text = 'text';

    case Number = 'number';

    public function getLabel(): string
    {
        return match ($this) {
            self::Checkbox => __('tinoecom-core::forms.checkbox'),
            self::ColorPicker => __('tinoecom-core::forms.color_picker'),
            self::DatePicker => __('tinoecom-core::forms.datepicker'),
            self::RichText => __('tinoecom-core::forms.rich_text'),
            self::Select => __('tinoecom-core::forms.select'),
            self::Text => __('tinoecom-core::forms.text_field', ['type' => '(input)']),
            self::Number => __('tinoecom-core::forms.text_field', ['type' => '(number)']),
        };
    }
}
