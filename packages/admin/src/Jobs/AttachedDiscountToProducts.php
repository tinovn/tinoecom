<?php

declare(strict_types=1);

namespace Tinoecom\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Tinoecom\Core\Enum\DiscountApplyTo;
use Tinoecom\Core\Models\Discount;
use Tinoecom\Core\Models\DiscountDetail;

class AttachedDiscountToProducts implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $applyTo,
        public array $productIds,
        public Discount $discount
    ) {}

    public function handle(): void
    {
        if ($this->applyTo === DiscountApplyTo::Products()) {
            // Remove all the products that's not been selected that already exist during creation of the discount
            $this->discount->items()
                ->where('condition', 'apply_to')
                ->whereNotIn('discountable_id', $this->productIds)
                ->delete();

            // Create or Update the associate the discount to all the selected products.
            foreach ($this->productIds as $productId) {
                DiscountDetail::query()->updateOrCreate(
                    attributes: [
                        'discount_id' => $this->discount->id,
                        'discountable_id' => $productId,
                        'discountable_type' => config('tinoecom.models.product'),
                    ],
                    values: ['condition' => 'apply_to']
                );
            }
        } else {
            $this->discount->items()
                ->where('condition', 'apply_to')
                ->delete();
        }
    }
}
