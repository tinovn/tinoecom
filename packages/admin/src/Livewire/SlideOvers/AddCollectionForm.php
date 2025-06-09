<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Tinoecom\Components\Form\SeoField;
use Tinoecom\Components\Section;
use Tinoecom\Core\Enum\CollectionType;
use Tinoecom\Core\Models\Collection;
use Tinoecom\Core\Repositories\CollectionRepository;
use Tinoecom\Livewire\Components\SlideOverComponent;

/**
 * @property Forms\Form $form
 */
class AddCollectionForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->authorize('add_collections');

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('tinoecom::words.general'))
                    ->collapsible()
                    ->compact()
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
                            ->unique(table: config('tinoecom.models.collection'), column: 'slug'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('tinoecom::forms.label.availability'))
                            ->native(false)
                            ->default(now())
                            ->minDate(now())
                            ->helperText(__('tinoecom::pages/collections.availability_description')),

                        Forms\Components\Radio::make('type')
                            ->label(__('tinoecom::pages/collections.filter_type'))
                            ->required()
                            ->options(CollectionType::class),

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
                    ]),

                Section::make(__('tinoecom::words.media'))
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('file')
                            ->label(__('tinoecom::forms.label.image_preview'))
                            ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                            ->image()
                            ->maxSize(config('tinoecom.media.max_size.thumbnail')),
                    ]),

                Section::make(__('tinoecom::words.seo.slug'))
                    ->collapsed()
                    ->compact()
                    ->schema(SeoField::make()),

                Section::make('Metadata')
                    ->collapsed()
                    ->compact()
                    ->schema([
                        Forms\Components\KeyValue::make('metadata')
                            ->reorderable(),
                    ]),
            ])
            ->statePath('data')
            ->model(config('tinoecom.models.collection'));
    }

    public function store(): void
    {
        /** @var Collection $collection */
        $collection = (new CollectionRepository)->create($this->form->getState());
        $this->form->model($collection)->saveRelationships();

        Notification::make()
            ->title(__('tinoecom::notifications.create', ['item' => __('tinoecom::pages/collections.single')]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'tinoecom.collections.edit',
            parameters: ['collection' => $collection],
            navigate: true
        );
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.add-collection-form');
    }
}
