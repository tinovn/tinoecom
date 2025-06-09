<x-tinoecom::form-slider-over
    action="store"
    :title="$discount->id ? $discount->code : __('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/discounts.single')])"
    :description="__('tinoecom::pages/discounts.description')"
>
    {{ $this->form }}
</x-tinoecom::form-slider-over>
