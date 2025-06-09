<?php

declare(strict_types=1);

use Tinoecom\Core\Enum\CollectionType;
use Tinoecom\Core\Models\Collection;
use Tinoecom\Core\Models\Product;
use Tinoecom\Livewire\Modals\CollectionProductsList;
use Tinoecom\Tests\Admin\Features\TestCase;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses(TestCase::class);

it('can have correct products after search', function (): void {
    Product::factory(['name' => 'Traditionnal Pagne'])->create();
    Product::factory(['name' => 'Veronique Shoe'])->create();
    Product::factory(['name' => 'Monney bag by Laurence'])->create();
    Product::factory(['name' => 'Matanga basket shoes'])->create();
    $collection = Collection::factory(['type' => CollectionType::Manual])->create();

    get(route('tinoecom.collections.edit', $collection))
        ->assertFound();

    $component = livewire(CollectionProductsList::class, ['collectionId' => $collection->id]);

    $component->assertSuccessful()->set('search', 'Laure');
    $this->assertEquals(1, $component->products->count());

    $component->set('search', 'shoe')
        ->assertSee(['Veronique Shoe', 'Matanga basket shoes'])
        ->set('selectedProducts', [3, 4])
        ->call('addSelectedProducts')
        ->assertDispatched('closeModal');

    $collection->refresh();

    expect($collection->products->count())->toBe(2);
})->group('collection');
