<?php

declare(strict_types=1);

use Tinoecom\Core\Models\Brand;
use Tinoecom\Core\Repositories\BrandRepository;
use Tinoecom\Livewire\Pages\Brand\Index;
use Tinoecom\Livewire\SlideOvers\BrandForm;
use Tinoecom\Tests\Admin\Features\TestCase;

use function Pest\Livewire\livewire;

uses(TestCase::class);

it('can render brand page', function (): void {
    $this->get($this->prefix . '/brands');

    livewire(Index::class)
        ->assertSee(__('tinoecom::pages/brands.menu'));
});

it('can validate `required` fields on brand form', function (): void {
    livewire(BrandForm::class)
        ->assertFormExists()
        ->fillForm([])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can create brand', function (): void {
    livewire(BrandForm::class)
        ->assertFormExists()
        ->fillForm([
            'name' => 'Nike',
        ])
        ->call('save')
        ->assertRedirectToRoute('tinoecom.brands.index');
});

it('will generate a slug when brand slug already exists', function (): void {
    Brand::factory()->create(['name' => 'Nike Old', 'slug' => 'nike']);

    livewire(BrandForm::class)
        ->assertFormExists()
        ->fillForm([
            'name' => 'Nike',
        ])
        ->call('save')
        ->assertRedirectToRoute('tinoecom.brands.index');

    expect((new BrandRepository)->count())
        ->toBe(2)
        ->and((new BrandRepository)->getById(2)?->slug)
        ->toBe('nike-1');
});
