<x-tinoecom::form-slider-over
    action="save"
    :title="$brand->id ? $brand->name : __('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/brands.single')])"
>
    {{ $this->form }}
</x-tinoecom::form-slider-over>
