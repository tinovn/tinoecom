<?php

declare(strict_types=1);

use Tinoecom\Core\Enum\CollectionType;
use Tinoecom\Core\Models\Collection;
use Tinoecom\Core\Repositories\CollectionRepository;
use Tinoecom\Livewire\Components\Collection\CollectionProducts;
use Tinoecom\Livewire\Modals\CollectionProductsList;
use Tinoecom\Livewire\Pages;
use Tinoecom\Livewire\SlideOvers\AddCollectionForm;
use Tinoecom\Livewire\SlideOvers\CollectionRules;
use Tinoecom\Tests\Admin\Features\TestCase;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses(TestCase::class);

it('can render collections page', function (): void {
get(route('tinoecom.collections.index'))
->assertFound();

    livewire(Pages\Collection\Index::class)
        ->assertSee(__('tinoecom::pages/collections.menu'));
    })->group('collection');

it('can validate `required` fields on add collection form', function (): void {
    livewire(AddCollectionForm::class)
        ->assertFormExists()
        ->fillForm([])
        ->call('store')
        ->assertHasFormErrors(['name' => 'required', 'type' => 'required']);
})->group('collection');

it('can create a collection', function (): void {
    livewire(AddCollectionForm::class)
        ->assertFormExists()
        ->fillForm([
            'name' => 'My manual collection',
            'type' => CollectionType::Manual(),
        ])
        ->call('store')
        ->assertHasNoFormErrors()
        ->assertRedirectToRoute(
            'tinoecom.collections.edit',
            [
                'collection' => (new CollectionRepository)->getById(1),
            ]
        );

    expect((new CollectionRepository)->count())->toBe(1);
})->group('collection');

it('can search collection by `name`', function (): void {
    $collections = Collection::factory()->count(10)->create();

    $name = $collections->first()->name;

    livewire(Pages\Collection\Index::class)
        ->searchTable($name)
        ->assertCanSeeTableRecords($collections->where('name', $name))
        ->assertCanNotSeeTableRecords($collections->where('name', '!=', $name));
})->group('collection');

it('can display the edit collection page by click on table action', function (): void {
    $collections = Collection::factory()->count(3)->create();
    $collection = $collections->first();

    livewire(Pages\Collection\Index::class)
        ->assertTableActionExists('edit')
        ->callTableAction('edit', $collection);

    livewire(Pages\Collection\Edit::class, ['collection' => $collection->id])
        ->assertSuccessful();
})->group('collection');

it('can render collection edit page', function (): void {
    $collection = Collection::factory()->create();

    get(route('tinoecom.collections.edit', $collection))
        ->assertFound();

    livewire(Pages\Collection\Edit::class, ['collection' => $collection->id])
        ->assertSee($collection->name);
})->group('collection');

it('can edit a collection', function (): void {
    $collection = Collection::factory()->create();

    livewire(Pages\Collection\Edit::class, ['collection' => $collection->id])
        ->fillForm([
            'name' => 'My manual collection',
        ])
        ->call('store')
        ->assertHasNoFormErrors()
        ->assertNotified(__('tinoecom::notifications.update', ['item' => __('tinoecom::pages/collections.single')]));

    expect($collection->refresh()->name)->toBe('My manual collection');
})->group('collection');

it('can\'t change type of collection on edit form', function (): void {
    $collection = Collection::factory(['type' => CollectionType::Manual()])->create();

    livewire(Pages\Collection\Edit::class, ['collection' => $collection->id])
        ->fillForm([
            'name' => 'My manual collection',
            'type' => CollectionType::Auto(),
        ])
        ->call('store')
        ->assertHasNoFormErrors();

    expect($collection->refresh()->type)->toBe(CollectionType::Manual);
})->group('collection');

it('can display products modal on manual collection', function (): void {
    $collection = Collection::factory(['type' => CollectionType::Manual()])->create();

    livewire(Pages\Collection\Edit::class, ['collection' => $collection->id])
        ->assertSee(__('tinoecom::forms.label.browse'))
        ->assertDontSeeText(__('tinoecom::pages/collections.conditions.title'));

    livewire(CollectionProducts::class, ['collection' => $collection])
        ->assertSuccessful()
        ->assertCountTableRecords(0)
        ->assertTableActionHidden('rules')
        ->assertTableActionExists('products')
        ->callTableAction('products');

    livewire(CollectionProductsList::class, ['collectionId' => $collection->id])
        ->assertSuccessful()
        ->assertSee(__('tinoecom::pages/collections.modal.title'));
})->group('collection');

it('can save rules on auto collection', function (): void {
    $collection = Collection::factory(['type' => CollectionType::Auto()])->create();

    livewire(Pages\Collection\Edit::class, ['collection' => $collection->id])
        ->assertSee(__('tinoecom::pages/collections.conditions.title'))
        ->assertDontSeeText(__('tinoecom::forms.label.browse'));

    livewire(CollectionProducts::class, ['collection' => $collection])
        ->assertSuccessful()
        ->assertCountTableRecords(0)
        ->assertTableActionHidden('products')
        ->assertTableActionExists('rules')
        ->callTableAction('rules');

    livewire(CollectionRules::class, ['collection' => $collection])
        ->assertSuccessful()
        ->assertFormExists()
        ->fillForm([])
        ->call('store')
        ->assertHasNoFormErrors();
})->group('collection');
