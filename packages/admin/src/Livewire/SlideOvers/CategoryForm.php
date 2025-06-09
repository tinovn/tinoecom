<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Tinoecom\Components\Form\SeoField;
use Tinoecom\Components\Section;
use Tinoecom\Core\Repositories\CategoryRepository;
use Tinoecom\Livewire\Components\SlideOverComponent;

/**
 * @property Form $form
 */
class CategoryForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public $category;

    public ?array $data = [];

    public function mount(?int $categoryId = null): void
    {
        $this->category = $categoryId
            ? (new CategoryRepository)->query()->find($categoryId)
            : (new CategoryRepository)->query()->newModelInstance();

        $this->form->fill($this->category->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('tinoecom::words.general'))
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Components\TextInput::make('name')
                            ->label(__('tinoecom::forms.label.name'))
                            ->placeholder('Women, Baby Shoes, MacBook...')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                                $set('slug', Str::slug($state));
                            }),
                        Components\Hidden::make('slug'),
                        Components\Select::make('parent_id')
                            ->label(__('tinoecom::forms.label.parent'))
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('is_enabled', true)
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->load('parent')->getLabelOptionName())
                            ->preload()
                            ->searchable()
                            ->optionsLimit(20)
                            ->placeholder(__('tinoecom::pages/categories.empty_parent')),
                        Components\Toggle::make('is_enabled')
                            ->label(__('tinoecom::forms.label.visibility'))
                            ->helperText(__('tinoecom::words.set_visibility', ['name' => __('tinoecom::pages/categories.single')])),
                        Components\RichEditor::make('description')
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
                        Components\SpatieMediaLibraryFileUpload::make('file')
                            ->label(__('tinoecom::forms.label.image_preview'))
                            ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                            ->image()
                            ->maxSize(config('tinoecom.media.max_size.thumbnail')),
                    ]),
                Section::make(__('tinoecom::words.seo.slug'))
                    ->collapsible()
                    ->compact()
                    ->schema(SeoField::make()),
                Section::make('Metadata')
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Components\KeyValue::make('metadata')
                            ->reorderable(),
                    ]),
            ])
            ->statePath('data')
            ->model($this->category);
    }

    public function save(): void
    {
        if ($this->category->id) {
            $this->authorize('edit_categories', $this->category);

            $this->category->update($this->form->getState());
        } else {
            $this->authorize('add_categories');

            $category = (new CategoryRepository)->create($this->form->getState());
            $this->form->model($category)->saveRelationships();
        }

        Notification::make()
            ->title(__('tinoecom::notifications.save', ['item' => __('tinoecom::pages/categories.single')]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'tinoecom.categories.index',
            navigate: true,
        );
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.category-form');
    }
}
