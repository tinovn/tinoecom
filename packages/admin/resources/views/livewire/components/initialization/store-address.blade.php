<div class="flex flex-col justify-between space-y-10 lg:space-y-20">
    @include('tinoecom::livewire.components.initialization.steps')

    <form wire:submit="save" class="flex-1">
        <div class="space-y-10">
            <div class="space-y-3">
                <div class="flex items-center space-x-4">
                    <x-untitledui-globe-05
                        class="size-6 text-gray-400 dark:text-gray-500"
                        aria-hidden="true"
                        stroke-width="1"
                    />
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-500">
                        {{ __('tinoecom::pages/onboarding.step_2') }}
                    </span>
                </div>
                <h2 class="font-heading text-2xl font-medium text-gray-900 dark:text-white">
                    {{ __('tinoecom::pages/onboarding.address_description') }}
                </h2>
                <p class="text-sm leading-6 text-gray-500 dark:text-gray-300 lg:max-w-2xl">
                    {{ __('tinoecom::pages/onboarding.step_2_description') }}
                </p>
            </div>
            <div class="mt-10">
                {{ $this->form }}
            </div>
        </div>
        <div class="mt-8 border-t border-dashed border-gray-200 pt-10 dark:border-white/10">
            <div class="flex items-center justify-between space-x-4">
                <x-tinoecom::buttons.default type="button" wire:click="previousStep">
                    {{ __('tinoecom::forms.actions.back') }}
                </x-tinoecom::buttons.default>
                <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
                    <x-tinoecom::loader wire:loading wire:target="save" class="text-white" aria-hidden="true" />
                    {{ __('tinoecom::forms.actions.next') }}
                </x-tinoecom::buttons.primary>
            </div>
        </div>
    </form>
</div>
