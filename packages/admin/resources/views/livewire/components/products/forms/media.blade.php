<x-tinoecom::container>
    <form wire:submit="store">
        {{ $this->form }}

        <div class="mt-10 border-t border-gray-200 pt-8 dark:border-white/10">
            <div class="flex justify-end">
                <x-tinoecom::buttons.primary type="submit" wire.loading.attr="disabled">
                    <x-tinoecom::loader wire:loading wire:target="store" />
                    {{ __('tinoecom::forms.actions.update') }}
                </x-tinoecom::buttons.primary>
            </div>
        </div>
    </form>
</x-tinoecom::container>
