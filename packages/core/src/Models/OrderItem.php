<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tinoecom\Core\Database\Factories\OrderItemFactory;

/**
 * @property-read int $id
 * @property string $name
 * @property int $quantity
 * @property int $unit_price_amount
 * @property int $total
 * @property string $sku
 * @property int $product_id
 * @property string $product_type
 * @property int $order_id
 * @property Order $order
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getTable(): string
    {
        return tinoecom_table('order_items');
    }

    protected static function newFactory(): OrderItemFactory
    {
        return OrderItemFactory::new();
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->unit_price_amount * $this->quantity
        );
    }

    public function product(): MorphTo
    {
        return $this->morphTo();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
