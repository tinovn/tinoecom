@props([
    'icon',
    'theme',
])

@php
    $label = __('tinoecom::forms.actions.theme_switcher', ['label' => $theme]);
@endphp

<button
    aria-label="{{ $label }}"
    type="button"
    x-on:click="(theme = @js($theme)) && close()"
    x-tooltip="{
        content: @js($label),
        theme: $store.theme,
    }"
    class="fi-theme-switcher-btn flex justify-center rounded-md p-2 outline-none transition duration-75 hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5"
    x-bind:class="
        theme === @js($theme)
            ? 'fi-active bg-gray-50 text-primary-500 dark:bg-white/5 dark:text-primary-400'
            : 'text-gray-400 hover:text-gray-500 focus-visible:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:focus-visible:text-gray-400'
    "
>
    <x-filament::icon :alias="'tinoecom::theme-switcher.' . $theme . '-button'" :icon="$icon" class="size-5" />
</button>
