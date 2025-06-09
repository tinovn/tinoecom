<x-tinoecom::form-slider-over
    action="save"
    :title="$category->id ? $category->name :__('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/categories.single')])"
>
    {{ $this->form }}
</x-tinoecom::form-slider-over>
