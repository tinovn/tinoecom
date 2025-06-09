<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Tinoecom\Core\Models\DiscountDetail;

trait HasDiscounts
{
    /**
     * @return MorphToMany<DiscountDetail, $this>
     */
    public function discounts(): MorphToMany
    {
        return $this->morphedByMany(DiscountDetail::class, 'discountable')
            ->orderBy('created_at', 'desc');
    }
}
