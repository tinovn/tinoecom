import tinoecomPreset from './packages/admin/tailwind.config.preset'
import filamentPreset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
  presets: [filamentPreset, tinoecomPreset],
  content: [
    './packages/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './vendor/jaocero/radio-deck/resources/views/**/*.blade.php',
  ],
}
