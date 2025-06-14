<div
    x-data="{ theme: null }"
    x-init="
        $watch('theme', () => {
            $dispatch('theme-changed', theme)
        })

        theme = localStorage.getItem('theme') || 'system'
    "
    class="fi-theme-switcher grid grid-flow-col gap-x-1"
>
    <x-tinoecom::theme-switcher.button icon="heroicon-m-sun" theme="light" />

    <x-tinoecom::theme-switcher.button icon="heroicon-m-moon" theme="dark" />

    <x-tinoecom::theme-switcher.button icon="heroicon-m-computer-desktop" theme="system" />
</div>
