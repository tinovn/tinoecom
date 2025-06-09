<x-tinoecom::modal
    headerClasses="p-4 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-white/10"
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
    form-action="save"
>
    <x-slot name="title">
        <span class="flex flex-col">
            <span>{{ __('tinoecom::modals.roles.new') }}</span>
            <span class="text-base font-normal leading-5 text-gray-500 dark:text-gray-400">
                {{ __('tinoecom::modals.roles.new_description') }}
            </span>
        </span>
    </x-slot>

    <x-slot name="content">
        {{ $this->form }}
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-tinoecom::buttons.primary type="submit">
                <x-tinoecom::loader wire:loading wire:target="save" class="text-white" />
                {{ __('tinoecom::forms.actions.save') }}
            </x-tinoecom::buttons.primary>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-tinoecom::buttons.default wire:click="$dispatch('closeModal')" type="button">
                {{ __('tinoecom::forms.actions.cancel') }}
            </x-tinoecom::buttons.default>
        </span>
    </x-slot>
</x-tinoecom::modal>
