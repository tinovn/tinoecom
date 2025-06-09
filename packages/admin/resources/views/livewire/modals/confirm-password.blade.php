<x-tinoecom::modal
    headerClasses="p-4 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-white/10"
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
>
    <x-slot name="title">
        {{ __('tinoecom::forms.label.confirm_password') }}
    </x-slot>

    <x-slot name="content">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('tinoecom::pages/settings/global.confirm_password_content') }}
        </p>
        <div class="mt-4">
            <x-tinoecom::forms.input
                wire:model="confirmablePassword"
                id="confirmable_password"
                type="password"
                placeholder="{{ __('tinoecom::forms.placeholder.password') }}"
                aria-label="{{ __('tinoecom::forms.label.password') }}"
            />

            @error('confirmable_password')
                <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-tinoecom::buttons.primary wire:click="confirmPassword" type="button">
                <x-tinoecom::loader wire:loading wire:target="confirmPassword" class="text-white" />
                {{ __('tinoecom::forms.label.confirm') }}
            </x-tinoecom::buttons.primary>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-tinoecom::buttons.default wire:click="$dispatch('closeModal')" type="button">
                {{ __('tinoecom::forms.actions.nevermind') }}
            </x-tinoecom::buttons.default>
        </span>
    </x-slot>
</x-tinoecom::modal>
