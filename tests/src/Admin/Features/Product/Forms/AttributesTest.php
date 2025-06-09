<?php

declare(strict_types=1);

use Tinoecom\Core\Enum\FieldType;
use Tinoecom\Core\Models\Attribute;
use Tinoecom\Core\Models\AttributeValue;
use Tinoecom\Core\Models\Product;
use Tinoecom\Livewire\SlideOvers\ChooseProductAttributes;
use Tinoecom\Tests\Admin\Features\TestCase;

use function Pest\Livewire\livewire;

uses(TestCase::class);

beforeEach(function (): void {
    $this->product = Product::factory()->variant()->create();
    $this->colorAttribute = Attribute::factory()
        ->has(AttributeValue::factory()->count(3), 'values')
        ->create([
            'name' => 'Color',
            'slug' => 'color',
            'type' => FieldType::ColorPicker,
            'is_enabled' => true,
        ]);
    $this->sizeAttribute = Attribute::factory()
        ->has(AttributeValue::factory()->count(5), 'values')
        ->create([
            'name' => 'Size',
            'slug' => 'size',
            'type' => FieldType::Checkbox,
            'is_enabled' => true,
        ]);
    $this->dimensionAttribute = Attribute::factory()
        ->has(AttributeValue::factory()->count(10), 'values')
        ->create([
            'name' => 'Dimension',
            'slug' => 'dimension',
            'type' => FieldType::Checkbox,
            'is_enabled' => true,
        ]);
});

it('product can choose attributes', function (): void {
    livewire(ChooseProductAttributes::class, ['productId' => $this->product->id])
        ->fillForm([
            'attributes' => [$this->colorAttribute->id],
            'values' => [
                $this->colorAttribute->id => $this->colorAttribute->values
                    ->take(2)
                    ->pluck('id')
                    ->toArray(),
                $this->sizeAttribute->id => $this->sizeAttribute->values
                    ->take(4)
                    ->pluck('id')
                    ->toArray(),
            ],
        ])
        ->call('store')
        ->assertHasNoErrors()
        ->assertRedirectToRoute('tinoecom.products.edit', ['product' => $this->product->id, 'tab' => 'attributes']);

    expect($this->product->options->count())
        ->toBe(2);
})->group('product');
