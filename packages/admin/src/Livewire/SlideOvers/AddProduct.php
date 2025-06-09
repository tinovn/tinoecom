<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Tinoecom\Actions\Store\Product\CreateProductAction;
use Tinoecom\Components;
use Tinoecom\Core\Enum\ProductType;
use Tinoecom\Core\Repositories\ChannelRepository;
use Tinoecom\Feature;
use Tinoecom\Livewire\Components\Products\ProductTypeConfiguration;
use Tinoecom\Livewire\Components\SlideOverComponent;

/**
 * @property Form $form
 */
class AddProduct extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    /**
     * @var array<array-key, mixed>|null
     */
    public ?array $data = [];

    public int $startStep = 1;

    public ?string $currentProductType = null;

    public function mount(): void
    {
        $this->authorize('add_products');

        $this->currentProductType = tinoecom_setting('default_product_type');

        $this->startStep = $this->currentProductType ? 2 : 1;

        $this->form->fill(array_merge([
            'channels' => (new ChannelRepository)
                ->query()
                ->where('is_default', true)
                ->select('id')
                ->pluck('id')
                ->toArray(),
            'published_at' => now(),
            'is_visible' => true,
        ], $this->currentProductType ? ['type' => $this->currentProductType] : []));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\SlideOverWizard::make([
                    Components\Wizard\StepColumn::make(__('tinoecom::forms.label.type'))
                        ->icon('untitledui-dataflow-04')
                        ->schema([
                            RadioDeck::make('type')
                                ->options(ProductType::class)
                                ->descriptions(ProductType::class)
                                ->icons(ProductType::class)
                                ->alignment(Alignment::Start)
                                ->color('primary')
                                ->columns(3)
                                ->live()
                                ->required(),
                            Forms\Components\Livewire::make(ProductTypeConfiguration::class, fn (Forms\Get $get) => [
                                'defaultProductType' => $get('type'),
                            ]),
                        ]),

                    Components\Wizard\StepColumn::make(__('tinoecom::words.general'))
                        ->icon('untitledui-file-02')
                        ->extraAttributes([
                            'class' => 'w-full max-w-3xl mx-auto',
                        ])
                        ->schema([
                            Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label(__('tinoecom::forms.label.name'))
                                        ->placeholder('Table set')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function ($state, Forms\Set $set): void {
                                            $set('slug', Str::slug($state));
                                        }),
                                    Forms\Components\TextInput::make('slug')
                                        ->label(__('tinoecom::forms.label.slug'))
                                        ->placeholder('table-set')
                                        ->disabled()
                                        ->dehydrated()
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(config('tinoecom.models.product'), 'slug'),

                                    Forms\Components\Textarea::make('summary')
                                        ->label(__('tinoecom::forms.label.summary'))
                                        ->rows(4)
                                        ->columnSpan('full'),

                                    Forms\Components\RichEditor::make('description')
                                        ->label(__('tinoecom::forms.label.description'))
                                        ->columnSpan('full'),
                                ])
                                ->compact()
                                ->columns(),

                            Components\Separator::make(),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\Toggle::make('is_visible')
                                        ->label(__('tinoecom::forms.label.visible'))
                                        ->helperText(__('tinoecom::pages/products.visible_help_text')),

                                    Forms\Components\DateTimePicker::make('published_at')
                                        ->label(__('tinoecom::forms.label.availability'))
                                        ->native(false)
                                        ->minDate(now()->subHour())
                                        ->helperText(__('tinoecom::pages/products.availability_description'))
                                        ->required(),
                                ]),
                        ]),

                    Components\Wizard\StepColumn::make(__('tinoecom::pages/products.product_associations'))
                        ->icon('untitledui-git-branch')
                        ->extraAttributes([
                            'class' => 'w-full max-w-3xl mx-auto',
                        ])
                        ->schema([
                            Forms\Components\Select::make('brand_id')
                                ->label(__('tinoecom::forms.label.brand'))
                                ->relationship(
                                    name: 'brand',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query) => $query->where('is_enabled', true)
                                )
                                ->searchable()
                                ->optionsLimit(10)
                                ->preload()
                                ->visible(Feature::enabled('brand')),

                            SelectTree::make('categories')
                                ->label(__('tinoecom::pages/categories.menu'))
                                ->enableBranchNode()
                                ->relationship(
                                    relationship: 'categories',
                                    titleAttribute: 'name',
                                    parentAttribute: 'parent_id',
                                    modifyQueryUsing: fn (Builder $query) => $query->where('is_enabled', true)
                                )
                                ->searchable()
                                ->visible(Feature::enabled('category'))
                                ->withCount(),

                            Forms\Components\Select::make('channels')
                                ->label(__('tinoecom::pages/settings/menu.sales'))
                                ->relationship(
                                    name: 'channels',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query) => $query->where('is_enabled', true)
                                )
                                ->searchable()
                                ->preload()
                                ->multiple(),

                            Forms\Components\Select::make('collections')
                                ->label(__('tinoecom::pages/collections.menu'))
                                ->relationship('collections', 'name')
                                ->searchable()
                                ->preload()
                                ->multiple()
                                ->optionsLimit(10)
                                ->visible(Feature::enabled('collection')),
                        ])
                        ->columns()
                        ->visible(
                            Feature::enabled('brand')
                            || Feature::enabled('category')
                            || Feature::enabled('collection')
                        ),

                    Components\Wizard\StepColumn::make(__('tinoecom::words.media'))
                        ->icon('untitledui-image')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                                ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                                ->label(__('tinoecom::forms.label.thumbnail'))
                                ->helperText(__('tinoecom::pages/products.thumbnail_helpText'))
                                ->image()
                                ->maxSize(config('tinoecom.media.max_size.thumbnail'))
                                ->columnSpan(['lg' => 2]),

                            Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                                ->collection(config('tinoecom.media.storage.collection_name'))
                                ->label(__('tinoecom::words.images'))
                                ->helperText(__('tinoecom::pages/products.images_helpText'))
                                ->multiple()
                                ->panelLayout('grid')
                                ->maxSize(config('tinoecom.media.max_size.images'))
                                ->columnSpanFull(),
                        ])
                        ->columns(5),

                    Components\Wizard\StepColumn::make(__('tinoecom::pages/products.stock_inventory_heading'))
                        ->icon('untitledui-package')
                        ->schema([
                            Forms\Components\Placeholder::make('stock')
                                ->label(__('tinoecom::pages/products.stock_inventory_heading'))
                                ->content(new HtmlString(Blade::render(<<<'BLADE'
                                    <p class="max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('tinoecom::pages/products.stock_inventory_description', ['item' => __('tinoecom::pages/products.single')]) }}
                                    </p>
                                BLADE))),

                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('sku')
                                        ->label(__('tinoecom::forms.label.sku'))
                                        ->unique(config('tinoecom.models.product'), 'sku')
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('barcode')
                                        ->label(__('tinoecom::forms.label.barcode'))
                                        ->unique(config('tinoecom.models.product'), 'barcode')
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label(__('tinoecom::forms.label.quantity'))
                                        ->numeric()
                                        ->rules(['integer', 'min:0']),

                                    Forms\Components\TextInput::make('security_stock')
                                        ->label(__('tinoecom::forms.label.safety_stock'))
                                        ->helperText(__('tinoecom::pages/products.safety_security_help_text'))
                                        ->numeric()
                                        ->default(0)
                                        ->rules(['integer', 'min:0']),
                                ])
                                ->columns(),
                        ]),
                ])
                    ->startOnStep($this->startStep)
                    ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                        <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
                            <x-tinoecom::loader wire:loading wire:target="store" class="text-white" />
                            {{ __('tinoecom::forms.actions.save') }}
                        </x-tinoecom::buttons.primary>
                     BLADE)))
                    ->persistStepInQueryString(),
            ])
            ->statePath('data')
            ->model(config('tinoecom.models.product'));
    }

    public function store(): void
    {
        $this->validate();

        $product = app()->call(CreateProductAction::class, [
            'form' => $this->form,
        ]);

        Notification::make()
            ->title(__('tinoecom::notifications.create', ['item' => $product->name]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'tinoecom.products.edit',
            parameters: ['product' => $product],
            navigate: true
        );
    }

    public static function panelMaxWidth(): string
    {
        return '5xl';
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.add-product-form');
    }
}
