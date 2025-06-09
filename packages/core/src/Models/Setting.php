<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Tinoecom\Core\Database\Factories\SettingFactory;

/**
 * @property-read int $id
 * @property string $key
 * @property string $display_name
 * @property mixed $value
 */
class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'locked',
    ];

    protected $casts = [
        'value' => 'array',
        'locked' => 'boolean',
    ];

    public function getTable(): string
    {
        return tinoecom_table('settings');
    }

    protected static function newFactory(): SettingFactory
    {
        return SettingFactory::new();
    }

    public static function lockedAttributesDisplayName(string $key): string
    {
        return match ($key) {
            'name' => __('tinoecom::forms.label.store_name'),
            'legal_name' => __('tinoecom::forms.label.legal_name'),
            'email' => __('tinoecom::forms.label.email'),
            'logo' => __('tinoecom::forms.label.logo'),
            'cover' => __('tinoecom::forms.label.cover_photo'),
            'about' => __('tinoecom::forms.label.about'),
            'country_id' => __('tinoecom::forms.label.country'),
            'default_currency_id' => __('tinoecom::forms.label.currency'),
            'default_product_type' => __('tinoecom::pages/products.type'),
            'currencies' => __('tinoecom::forms.label.currencies'),
            'street_address' => __('tinoecom::forms.label.street_address'),
            'postal_code' => __('tinoecom::forms.label.postal_code'),
            'city' => __('tinoecom::forms.label.city'),
            'phone_number' => __('tinoecom::forms.label.phone_number'),
            'longitude' => __('tinoecom::forms.label.longitude'),
            'latitude' => __('tinoecom::forms.label.latitude'),
            'facebook_link' => __('tinoecom::words.socials.facebook'),
            'instagram_link' => __('tinoecom::words.socials.twitter'),
            'twitter_link' => __('tinoecom::words.socials.instagram'),
            default => Str::title($key),
        };
    }
}
