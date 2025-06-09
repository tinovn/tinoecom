<x-tinoecom::form-slider-over action="store" :title="__('tinoecom::pages/settings/staff.add_admin')">
    {{ $this->form }}

    <x-tinoecom::alert
        class="mt-6"
        icon="untitledui-alert-triangle"
        :title="__('tinoecom::words.attention_needed')"
        :message="__('tinoecom::words.attention_description', ['role' => config('tinoecom.core.users.admin_role')])"
    />
</x-tinoecom::form-slider-over>
