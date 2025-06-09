<x-tinoecom::layouts.base :title="__('tinoecom::pages/auth.two_factor.title')">
    <x-tinoecom::auth-card>
        <div x-data="{ recovery: false }" class="space-y-4">
            <x-tinoecom::validation-errors />

            <div>
                <x-tinoecom::brand class="mx-auto h-12 w-auto" />

                <div class="mt-6 text-center">
                    <h2
                        class="inline-flex items-center text-center font-heading text-xl font-medium leading-9 text-gray-900 dark:text-white"
                    >
                        <x-heroicon-o-shield-check class="-ml-1 mr-2 size-10 text-primary-600" aria-hidden="true" />
                        {{ __('tinoecom::pages/auth.two_factor.subtitle') }}
                    </h2>
                    <p
                        class="mt-1 text-center text-sm leading-5 text-gray-500 dark:text-gray-400"
                        x-show="! recovery"
                    >
                        {{ __('tinoecom::pages/auth.two_factor.authentication_code') }}
                    </p>
                    <p
                        class="mt-1 text-center text-sm leading-5 text-gray-500 dark:text-gray-400"
                        x-show="recovery"
                        style="display: none"
                    >
                        {{ __('tinoecom::pages/auth.two_factor.recovery_code') }}
                    </p>
                </div>
                <form class="mt-5" action="{{ route('tinoecom.two-factor.post-login') }}" method="POST">
                    @csrf
                    <x-tinoecom::forms.group x-show="! recovery" :label="__('tinoecom::forms.label.code')" for="code">
                        <x-tinoecom::forms.input
                            id="code"
                            type="text"
                            name="code"
                            autofocus
                            x-ref="code"
                            autocomplete="one-time-code"
                        />
                    </x-tinoecom::forms.group>

                    <x-tinoecom::forms.group
                        x-show="recovery"
                        :label="__('tinoecom::forms.label.recovery_code')"
                        for="recovery_code"
                        style="display: none"
                    >
                        <x-tinoecom::forms.input
                            id="recovery_code"
                            name="recovery_code"
                            type="text"
                            x-ref="recovery_code"
                            autocomplete="one-time-code"
                        />
                    </x-tinoecom::forms.group>

                    <div class="mt-5 flex items-center space-x-4">
                        <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                            {{ __('tinoecom::pages/auth.two_factor.remember') }}
                            <button
                                class="ml-1 cursor-pointer text-sm text-gray-500 underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                type="button"
                                x-show="! recovery"
                                x-on:click="
                                    recovery = true
                                    $nextTick(() => {
                                        $refs.recovery_code.focus()
                                    })
                                "
                            >
                                {{ __('tinoecom::pages/auth.two_factor.use_recovery_code') }}
                            </button>

                            <button
                                x-show="recovery"
                                type="button"
                                class="ml-1 cursor-pointer text-sm text-gray-500 underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                style="display: none"
                                x-on:click="
                                    recovery = false
                                    $nextTick(() => {
                                        $refs.code.focus()
                                    })
                                "
                            >
                                {{ __('tinoecom::pages/auth.two_factor.use_authentication_code') }}
                            </button>
                        </p>
                        <x-tinoecom::buttons.primary type="submit">
                            {{ __('tinoecom::pages/auth.two_factor.action') }}
                        </x-tinoecom::buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    </x-tinoecom::auth-card>
</x-tinoecom::layouts.base>
