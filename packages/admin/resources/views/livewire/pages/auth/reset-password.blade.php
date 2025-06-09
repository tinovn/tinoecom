<x-tinoecom::auth-card>
    <div class="space-y-4">
        <x-tinoecom::validation-errors />

        <div>
            <x-tinoecom::brand class="mx-auto h-12 w-auto" />

            <h2 class="mt-6 text-center font-heading text-3xl font-bold leading-9 text-gray-900 dark:text-white">
                {{ __('tinoecom::pages/auth.reset.title') }}
            </h2>
            <p class="mt-3 text-center text-sm leading-5">
                {{ __('tinoecom::pages/auth.reset.message') }}
            </p>
        </div>
    </div>
    <form class="mt-6" wire:submit="resetPassword">
        <input wire:model="token" type="hidden" />

        <div class="rounded-lg shadow-sm">
            <div>
                <input
                    aria-label="{{ __('tinoecom::forms.label.email') }}"
                    value="{{ $email ?? old('email') }}"
                    name="email"
                    type="email"
                    wire:model="email"
                    autocomplete="off"
                    class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:border-white/10 dark:bg-gray-800 dark:text-gray-300 dark:focus:ring-offset-gray-900 sm:text-sm"
                    placeholder="{{ __('tinoecom::forms.label.email') }}"
                    required
                    autofocus
                />
            </div>
            <div class="-mt-px">
                <input
                    aria-label="{{ __('tinoecom::forms.label.password') }}"
                    name="password"
                    type="password"
                    wire:model="password"
                    class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:border-white/10 dark:bg-gray-800 dark:text-gray-300 dark:focus:ring-offset-gray-900 sm:text-sm"
                    placeholder="{{ __('tinoecom::forms.label.new_password') }}"
                    required
                />
            </div>
        </div>

        <div class="mt-5">
            <x-tinoecom::buttons.primary type="submit" class="w-full justify-center">
                <x-tinoecom::loader wire:loading wire:target="resetPassword" class="text-white" />
                {{ __('tinoecom::pages/auth.reset.action') }}
            </x-tinoecom::buttons.primary>
        </div>
    </form>
</x-tinoecom::auth-card>
