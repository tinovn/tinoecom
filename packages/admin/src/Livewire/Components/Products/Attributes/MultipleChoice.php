<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Products\Attributes;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Tinoecom\Core\Models\Attribute;
use Tinoecom\Core\Models\AttributeProduct;
use Tinoecom\Core\Models\Product;

/**
 * @property Collection $currentValues
 */
class MultipleChoice extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Product $product;

    public Attribute $attribute;

    public array $selected = [];

    public bool $activated;

    public function mount(): void
    {
        $this->selected = $this->currentValues->toArray();
    }

    #[Computed]
    public function currentValues(): Collection
    {
        return $this->product->options()
            ->where('attribute_id', $this->attribute->id)
            ->get()
            ->pluck('attribute_value_id');
    }

    public function saveAction(): Action
    {
        return Action::make('save')
            ->badge()
            ->action(function (): void {
                $toDelete = array_diff($this->currentValues->toArray(), $this->selected);

                if (count($toDelete) > 0) {
                    AttributeProduct::query()
                        ->where('product_id', $this->product->id)
                        ->whereIn('attribute_value_id', $toDelete)
                        ->delete();
                }

                foreach ($this->selected as $value) {
                    if (! $this->currentValues->contains($value)) {
                        AttributeProduct::query()->create([
                            'product_id' => $this->product->id,
                            'attribute_id' => $this->attribute->id,
                            'attribute_value_id' => $value,
                        ]);
                    }
                }

                Notification::make()
                    ->title(__('tinoecom::pages/products.attributes.session.added_message'))
                    ->success()
                    ->send();

                $this->dispatch('$refresh')->self();
            })
            ->visible(count($this->selected) > 0 || $this->currentValues->isNotEmpty());
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.products.attributes.multiple-choice');
    }
}
