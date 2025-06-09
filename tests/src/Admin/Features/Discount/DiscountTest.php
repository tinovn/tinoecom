<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Queue;
use Tinoecom\Core\Enum\DiscountApplyTo;
use Tinoecom\Core\Enum\DiscountEligibility;
use Tinoecom\Core\Enum\DiscountRequirement;
use Tinoecom\Core\Enum\DiscountType;
use Tinoecom\Core\Models\Discount;
use Tinoecom\Core\Models\Product;
use Tinoecom\Core\Models\User;
use Tinoecom\Jobs\AttachedDiscountToCustomers;
use Tinoecom\Jobs\AttachedDiscountToProducts;
use Tinoecom\Livewire\Pages;
use Tinoecom\Livewire\SlideOvers\DiscountForm;
use Tinoecom\Tests\Admin\Features\TestCase;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses(TestCase::class);

beforeEach(function (): void {
    $this->products = Product::factory()->count(3)->publish()->create();
    $this->users = User::factory()->count(3)->create();

    Queue::fake();
});

it('can render discounts page', function (): void {
get(route('tinoecom.discounts.index'))
->assertFound();

    livewire(Pages\Discount\Index::class)
        ->assertSee(__('tinoecom::pages/discounts.menu'));
    })->group('discount');

it('creates a new discount', function (): void {
    livewire(DiscountForm::class)
        ->fillForm([
            'code' => 'SUMMER23',
            'is_active' => true,
            'type' => DiscountType::FixedAmount(),
            'value' => 1000, // with fixed amount type, the value should be learned as "10.00 USD", the currency (USD) depend on your store config
            'apply_to' => DiscountApplyTo::Products(),
            'products' => $this->products->pluck('id')->toArray(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now(),
        ])
        ->call('store')
        ->assertHasNoFormErrors();

    Queue::assertPushed(AttachedDiscountToProducts::class);
    Queue::assertPushed(AttachedDiscountToCustomers::class);

    expect(Discount::query()->count())->toBe(1);

    Queue::assertCount(2);
})->group('discount');

it('should not create a discount with a date in the past', function (): void {
    livewire(DiscountForm::class)
        ->fillForm([
            'code' => 'SUMMER23',
            'is_active' => false,
            'type' => DiscountType::Percentage(),
            'value' => 10, // with percentage type, the value should be learned as "10%"
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subDays(10),
        ])
        ->call('store')
        ->assertHasFormErrors(['start_at']);
})->group('discount');

it('can update a discount', function (): void {
    $discount = Discount::factory()->create();

    livewire(DiscountForm::class, ['discountId' => $discount->id])
        ->fillForm([
            'code' => $code = 'LAURE_MONNEY_2025',
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Customers(),
            'customers' => $this->users->pluck('id')->toArray(),
        ])
        ->call('store')
        ->assertHasNoFormErrors();

    Queue::assertPushed(AttachedDiscountToProducts::class);
    Queue::assertPushed(AttachedDiscountToCustomers::class);

    $discount->refresh();

    expect($discount)->toBeInstanceOf(Discount::class)
        ->and($discount->code)
        ->toBe($code);

    Queue::assertCount(2);
})->group('discount');
