<div class="lg:grid lg:grid-cols-3 lg:gap-x-12 lg:gap-y-6">
    <x-tinoecom::section-heading class="lg:col-span-1" :title="$title" :description="$description" />

    <livewire:tinoecom-settings.legal.form :$legal />
</div>
