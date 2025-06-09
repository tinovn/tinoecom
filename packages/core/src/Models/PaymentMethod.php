<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tinoecom\Core\Database\Factories\PaymentMethodFactory;
use Tinoecom\Core\Traits\HasSlug;
use Tinoecom\Core\Traits\HasZones;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string|null $logo
 * @property string|null $logo_url
 * @property string|null $description
 * @property string|null $link_url
 * @property string|null $instructions
 */
class PaymentMethod extends Model
{
    use HasFactory;
    use HasSlug;
    use HasZones;

    protected $guarded = [];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    protected $appends = [
        'logo_url',
    ];

    public function getTable(): string
    {
        return tinoecom_table('payment_methods');
    }

    protected static function newFactory(): PaymentMethodFactory
    {
        return PaymentMethodFactory::new();
    }

    protected function LogoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->logo ? tinoecom_asset($this->logo) : null,
        );
    }

    /**
     * @param  Builder<PaymentMethod>  $query
     * @return Builder<PaymentMethod>
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }
}
