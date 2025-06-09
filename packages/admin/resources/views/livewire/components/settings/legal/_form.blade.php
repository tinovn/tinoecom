<form class="mt-5 max-w-3xl lg:col-span-2" wire:submit="store">
    {{ $this->form }}

    <div class="mt-6 flex justify-end">
        <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
            <x-tinoecom::loader wire:loading wire:target="store" class="text-white" />
            {{ __('tinoecom::forms.actions.save') }}
        </x-tinoecom::buttons.primary>
    </div>
</form>
