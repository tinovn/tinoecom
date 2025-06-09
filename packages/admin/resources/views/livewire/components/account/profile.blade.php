<form wire:submit="save" class="mt-10">
    {{ $this->form }}

    <div class="mt-8 grid grid-cols-1 gap-x-6 md:grid-cols-3 md:gap-x-12">
        <div class="flex justify-end md:col-span-2 md:col-start-2 lg:max-w-3xl">
            <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
                <x-tinoecom::loader wire:loading wire:target="save" class="text-white" />
                {{ __('tinoecom::forms.actions.save') }}
            </x-tinoecom::buttons.primary>
        </div>
    </div>
</form>
