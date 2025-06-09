<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Product;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Repositories\ProductRepository;
use Tinoecom\Core\Repositories\VariantRepository;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Variant extends AbstractPageComponent implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $product;

    public $variant;

    public function mount(int $productId, int $variantId): void
    {
        $this->authorize('edit_products');

        $this->product = (new ProductRepository)->getById($productId);
        $this->variant = (new VariantRepository)
            ->with([
                'prices',
                'media',
                'values',
                'values.attribute',
            ])
            ->getById($variantId);
    }

    public function updateStockAction(): Action
    {
        return Action::make('updateStock')
            ->label(__('tinoecom::forms.actions.edit'))
            ->color('gray')
            ->modalWidth(MaxWidth::ExtraLarge)
            ->fillForm([
                'sku' => $this->variant->sku,
                'barcode' => $this->variant->barcode,
            ])
            ->record($this->variant)
            ->form([
                Forms\Components\TextInput::make('sku')
                    ->label(__('tinoecom::forms.label.sku'))
                    ->unique(config('tinoecom.models.variant'), 'sku', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('barcode')
                    ->label(__('tinoecom::forms.label.barcode'))
                    ->unique(config('tinoecom.models.variant'), 'barcode', ignoreRecord: true)
                    ->maxLength(255),
            ])
            ->action(function (array $data): void {
                $this->variant->update($data);

                Notification::make()
                    ->title(__('tinoecom::pages/products.notifications.variation_update'))
                    ->success()
                    ->send();
            });
    }

    public function mediaAction(): Action
    {
        return Action::make('media')
            ->label(__('tinoecom::forms.actions.edit'))
            ->color('gray')
            ->record($this->variant)
            ->fillForm($this->variant->toArray())
            ->modalWidth(MaxWidth::ThreeExtraLarge)
            ->form([
                Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->label(__('tinoecom::forms.label.thumbnail'))
                    ->helperText(__('tinoecom::pages/products.thumbnail_helpText'))
                    ->image()
                    ->maxSize(config('tinoecom.media.max_size.thumbnail')),
                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->multiple()
                    ->label(__('tinoecom::words.images'))
                    ->panelLayout('grid')
                    ->helperText(__('tinoecom::pages/products.variant_images_helpText'))
                    ->collection(config('tinoecom.media.storage.collection_name'))
                    ->maxSize(config('tinoecom.media.max_size.images')),
            ]);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.products.variant')
            ->title(__('tinoecom::pages/products.variants.variant_title', ['name' => $this->variant->name]));
    }
}
