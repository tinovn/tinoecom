<form wire:submit="store" class="mt-10">
    {{ $this->form }}

    <div class="mt-10 border-t border-gray-200 pt-10 dark:border-white/10">
        <div class="flex items-center justify-end">
            <x-tinoecom::buttons.primary wire:click="store" type="submit" wire:loading.attr="disabled">
                <x-tinoecom::loader wire:loading wire:target="store" class="text-white" />
                {{ __('tinoecom::forms.actions.save') }}
            </x-tinoecom::buttons.primary>
        </div>
    </div>
</form>
