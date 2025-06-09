<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Enum\Operator;
use Tinoecom\Core\Enum\Rule;
use Tinoecom\Core\Models\Collection;
use Tinoecom\Livewire\Components\SlideOverComponent;

/**
 * @property Forms\Form $form
 */
class CollectionRules extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public Collection $collection;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->collection->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('match_conditions')
                    ->label(__('tinoecom::pages/collections.conditions.products_match'))
                    ->inline()
                    ->options([
                        'all' => __('tinoecom::pages/collections.conditions.all'),
                        'any' => __('tinoecom::pages/collections.conditions.any'),
                    ]),

                Forms\Components\Repeater::make('rules')
                    ->relationship()
                    ->label(__('tinoecom::pages/collections.conditions.title'))
                    ->addActionLabel(__('tinoecom::pages/collections.conditions.add'))
                    ->schema([
                        Forms\Components\Select::make('rule')
                            ->label(__('tinoecom::pages/collections.conditions.choose_rule'))
                            ->options(Rule::class)
                            ->required(),

                        Forms\Components\Select::make('operator')
                            ->label(__('tinoecom::pages/collections.conditions.select_operator'))
                            ->options(Operator::class)
                            ->required(),

                        Forms\Components\TextInput::make('value')
                            ->label(__('tinoecom::forms.label.value'))
                            ->required(),
                    ])
                    ->columns(3)
                    ->defaultItems(1),
            ])
            ->statePath('data')
            ->model($this->collection);
    }

    public function store(): void
    {
        $this->collection->update($this->form->getState());

        $this->closePanel();

        Notification::make()
            ->title(__('tinoecom::pages/collections.conditions.update'))
            ->success()
            ->send();
    }

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.collection-rules');
    }
}
