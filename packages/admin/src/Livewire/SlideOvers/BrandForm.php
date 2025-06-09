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
use Illuminate\Support\Str;
use Tinoecom\Components\Form\SeoField;
use Tinoecom\Components\Section;
use Tinoecom\Core\Repositories\BrandRepository;
use Tinoecom\Livewire\Components\SlideOverComponent;

/**
 * @property Form $form
 */
class BrandForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public $brand;

    public ?array $data = [];

    public function mount(?int $brandId = null): void
    {
        $this->brand = $brandId
            ? (new BrandRepository)->getById($brandId)
            : (new BrandRepository)->query()->newModelInstance();

        $this->form->fill($this->brand->toArray());
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
                            ->placeholder('Apple, Nike, Samsung...')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                                $set('slug', Str::slug($state));
                            }),
                        Components\Hidden::make('slug'),
                        Components\TextInput::make('website')
                            ->label(__('tinoecom::forms.label.website'))
                            ->placeholder('https://example.com')
                            ->url(),
                        Components\Toggle::make('is_enabled')
                            ->label(__('tinoecom::forms.label.visibility'))
                            ->helperText(__('tinoecom::words.set_visibility', ['name' => __('tinoecom::pages/brands.single')])),
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
            ->model($this->brand);
    }

    public function save(): void
    {
        if ($this->brand->id) {
            $this->authorize('edit_brands', $this->brand);

            $this->brand->update($this->form->getState());
        } else {
            $this->authorize('add_brands');

            $brand = (new BrandRepository)->create($this->form->getState());
            $this->form->model($brand)->saveRelationships();
        }

        Notification::make()
            ->title(__('tinoecom::notifications.save', ['item' => __('tinoecom::pages/brands.single')]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'tinoecom.brands.index',
            navigate: true,
        );
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.brand-form');
    }
}
