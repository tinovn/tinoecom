<x-tinoecom::attribute-card :activated="$activated" :attribute="$attribute">
    <x-slot:action>
        <div class="flex items-center gap-2">
            @if ($model)
                {{ ($this->removeAction)(['id' => $model->id]) }}
            @endif
        </div>
    </x-slot>
    <form wire:submit="store" class="space-y-3">
        {{ $this->form }}

        <div class="flex items-center justify-end">
            <x-filament::button type="submit" size="sm">
                {{ __('tinoecom::forms.actions.save') }}
            </x-filament::button>
        </div>
    </form>
</x-tinoecom::attribute-card>
