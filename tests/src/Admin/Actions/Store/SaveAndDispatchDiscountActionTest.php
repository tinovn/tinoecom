<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Queue;
use Tinoecom\Actions\Store\SaveAndDispatchDiscountAction;
use Tinoecom\Core\Enum\DiscountApplyTo;
use Tinoecom\Core\Enum\DiscountEligibility;
use Tinoecom\Core\Enum\DiscountRequirement;
use Tinoecom\Core\Enum\DiscountType;
use Tinoecom\Core\Models\Discount;
use Tinoecom\Core\Models\Product;
use Tinoecom\Core\Models\User;
use Tinoecom\Jobs\AttachedDiscountToCustomers;
use Tinoecom\Jobs\AttachedDiscountToProducts;
use Tinoecom\Tests\TestCase;

uses(TestCase::class);

/**
 * @var TestCase $this
 */
beforeEach(function (): void {
    $this->products = Product::factory()->count(3)->publish()->create();
    $this->users = User::factory()->count(3)->create();
    $this->formValues = [
        'code' => 'SUMMER23',
        'is_active' => true,
        'type' => DiscountType::FixedAmount(),
        'value' => 1000,
        'apply_to' => DiscountApplyTo::Products(),
        'min_required' => DiscountRequirement::None(),
        'eligibility' => DiscountEligibility::Everyone(),
        'start_at' => now(),
    ];

    Queue::fake();
});

describe(SaveAndDispatchDiscountAction::class, function (): void {
    it('should store a new discount', function (): void {
        $discount = app()->call(SaveAndDispatchDiscountAction::class, [
            'values' => $this->formValues,
        ]);

        Queue::assertPushed(AttachedDiscountToProducts::class);
        Queue::assertPushed(AttachedDiscountToCustomers::class);

        expect($discount)->toBeInstanceOf(Discount::class)
            ->and($discount->code)
            ->toBe('SUMMER23');

        Queue::assertCount(2);
    });

    it('should store a new discount for a product', function (): void {
        $discount = app()->call(SaveAndDispatchDiscountAction::class, [
            'values' => $this->formValues,
            'productsIds' => [$this->products->first()->id],
        ]);

        Queue::assertPushed(AttachedDiscountToProducts::class);
        Queue::assertPushed(AttachedDiscountToCustomers::class);

        expect($discount)->toBeInstanceOf(Discount::class);

        Queue::assertCount(2);
    });

    it('should update a discount for customers', function (): void {
        $discount = Discount::factory()->create();

        app()->call(SaveAndDispatchDiscountAction::class, [
            'values' => array_merge($this->formValues, [
                'code' => $code = 'LAURE_MONNEY_2025',
                'apply_to' => DiscountApplyTo::Products(),
                'value' => 5000,
                'min_required' => DiscountRequirement::Price(),
                'eligibility' => DiscountEligibility::Customers(),
            ]),
            'productsIds' => [$this->products->first()->id],
            'discountId' => $discount->id,
            'customersIds' => $this->users->pluck('id')->toArray(),
        ]);

        Queue::assertPushed(AttachedDiscountToProducts::class);
        Queue::assertPushed(AttachedDiscountToCustomers::class);

        $discount->refresh();

        expect($discount)->toBeInstanceOf(Discount::class)
            ->and($discount->code)
            ->toBe($code);

        Queue::assertCount(2);
    });
})->group('discount');
