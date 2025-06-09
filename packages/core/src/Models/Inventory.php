<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tinoecom\Core\Database\Factories\InventoryFactory;
use Tinoecom\Core\Observers\InventoryObserver;

/**
 * @property-read int $id
 * @property int $country_id
 * @property string $name
 * @property string $code
 * @property string $email
 * @property string $city
 * @property string|null $description
 * @property string|null $street_address
 * @property string|null $street_address_plus
 * @property string $postal_code
 * @property string|null $phone_number
 * @property bool $is_default
 */
#[ObservedBy(InventoryObserver::class)]
class Inventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function getTable(): string
    {
        return tinoecom_table('inventories');
    }

    protected static function newFactory(): InventoryFactory
    {
        return InventoryFactory::new();
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class);
    }
}
