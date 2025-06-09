<x-tinoecom::form-slider-over
    action="store"
    :title="$attribute
        ? $attribute->name
        : __('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/attributes.single')])
    "
>
    {{ $this->form }}
</x-tinoecom::form-slider-over>
