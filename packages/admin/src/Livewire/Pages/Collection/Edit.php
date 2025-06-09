<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Collection;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Tinoecom\Components\Form\SeoField;
use Tinoecom\Core\Repositories\CollectionRepository;
use Tinoecom\Livewire\Components\Collection\CollectionProducts;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

/**
 * @property Form $form
 */
class Edit extends AbstractPageComponent implements HasForms
{
    use InteractsWithForms;

    public $collection;

    public ?array $data = [];

    public function mount(int $collection): void
    {
        $this->authorize('edit_collections');

        $this->collection = (new CollectionRepository)->with('rules')->getById($collection);

        $this->form->fill($this->collection->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('tinoecom::forms.label.name'))
                                    ->placeholder('Summers Collections, Christmas promotions...')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set): void {
                                        $set('slug', Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('slug')
                                    ->label(__('tinoecom::forms.label.slug'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(config('tinoecom.models.collection'), 'slug', ignoreRecord: true),
                            ]),

                        Forms\Components\RichEditor::make('description')
                            ->label(__('tinoecom::forms.label.description'))
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),

                        Forms\Components\Livewire::make(CollectionProducts::class, ['collection' => $this->collection]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('file')
                            ->label(__('tinoecom::forms.label.image_preview'))
                            ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                            ->image()
                            ->maxSize(config('tinoecom.media.max_size.thumbnail')),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('tinoecom::forms.label.availability'))
                            ->native(false)
                            ->default(now())
                            ->helperText(__('tinoecom::pages/collections.availability_description')),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Placeholder::make(__('tinoecom::words.seo.slug'))
                                    ->label(__('tinoecom::words.seo.title'))
                                    ->content(new HtmlString(Blade::render(<<<'BLADE'
                                        <p class="max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('tinoecom::words.seo.description', ['name' => __('tinoecom::pages/collections.single')]) }}
                                        </p>
                                    BLADE))),

                                ...SeoField::make(),
                            ]),

                        Forms\Components\KeyValue::make('metadata')
                            ->reorderable(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3)
            ->statePath('data')
            ->model($this->collection);
    }

    public function store(): void
    {
        $this->collection->update($this->form->getState());

        Notification::make()
            ->title(__('tinoecom::notifications.update', ['item' => __('tinoecom::pages/collections.single')]))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.collections.edit')
            ->title(__('tinoecom::forms.actions.edit_label', ['label' => $this->collection->name]));
    }
}
