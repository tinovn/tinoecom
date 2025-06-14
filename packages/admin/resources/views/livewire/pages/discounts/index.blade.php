@php
    $total = $this->table->getRecords()->total();
@endphp

<x-tinoecom::container class="py-5">
    <x-tinoecom::heading :title="__('tinoecom::pages/discounts.menu')">
        <x-slot name="action">
            @if ($total > 0)
                @can('add_discounts')
                    <x-tinoecom::buttons.primary
                        type="button"
                        wire:click="$dispatch('openPanel', { component: 'tinoecom-slide-overs.discount-form' })"
                    >
                        {{ __('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/discounts.single')]) }}
                    </x-tinoecom::buttons.primary>
                @endcan
            @endif
        </x-slot>
    </x-tinoecom::heading>

    @if ($total === 0)
        <x-tinoecom::empty-state
            :title="__('tinoecom::pages/discounts.title')"
            :content="__('tinoecom::pages/discounts.description')"
            :button="__('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/discounts.single')])"
            permission="add_discounts"
            panel="{ component: 'tinoecom-slide-overs.discount-form' }"
        >
            <div class="shrink-0">
                <svg class="h-64 w-auto lg:h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 528 380">
                    <style>
                        .st0 {
                            fill: #e1e1e1;
                        }
                        .st1 {
                            fill: #ececec;
                        }
                        .st2 {
                            fill: #407bff;
                        }
                        .st4 {
                            fill: #f5f5f5;
                        }
                        .st5 {
                            fill: #263238;
                        }
                        .st6,
                        .st7 {
                            enable-background: new;
                        }
                        .st6 {
                            fill: #fff;
                            opacity: 0.6;
                        }
                        .st7 {
                            opacity: 0.2;
                        }
                        .st8 {
                            fill: #fff;
                        }
                        .st9 {
                            opacity: 0.3;
                            enable-background: new;
                        }
                        .st10 {
                            fill: #ebb376;
                        }
                        .st11 {
                            stroke-width: 0.4885;
                        }
                        .st11,
                        .st16,
                        .st18 {
                            fill: none;
                            stroke: #263238;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }
                        .st18 {
                            stroke: #407bff;
                        }
                        .st19 {
                            fill: #0064f5;
                        }
                        .st21 {
                            fill: #1a2e35;
                        }
                    </style>
                    <path
                        class="st0"
                        d="M91.6 223.9v-3c0-2 0-4.8-.1-8.4l.1.1c-9.7 0-25.1 0-42.4.1l.2-.2v11.4l-.2-.2c12.1 0 22.7.1 30.2.1 3.8 0 6.8 0 8.9.1h3.1-3c-2.1 0-5.1 0-8.9.1-7.6 0-18.2.1-30.4.1h-.2v-11.6l.2-.2c17.3 0 32.7.1 42.4.1h.1v.1c0 3.6 0 6.5-.1 8.5v2.2c0 .2 0 .4.1.7z"
                    />
                    <path
                        class="st0"
                        d="M96.3 235.3v-3.1c0-2 0-4.8-.1-8.3l.1.1H75.1l.2-.2v11.4l-.2-.2c6.2 0 11.4.1 15.2.1h5.6c.3.2.4.2.4.2h-5.9c-3.8 0-9.1.1-15.3.1h-.2v-11.5.1l.2-.2h21.3v.1c0 3.5-.1 6.4-.1 8.4v3z"
                    />
                    <path class="st1" d="M344.3 199.1h42.4v11.4h-42.4z" />
                    <path
                        class="st0"
                        d="M404.4 222.2v-3c0-2 0-4.8-.1-8.4l.1.1c-9.7 0-25.1 0-42.4.1l.2-.2v11.4l-.2-.2c12.1 0 22.7.1 30.2.1 3.8 0 6.8 0 8.9.1h3.1-3c-2.1 0-5.1 0-8.9.1-7.6 0-18.2.1-30.4.1h-.2v-11.5l.2-.2c17.3 0 32.7.1 42.4.1h.1v.1c0 3.6 0 6.5-.1 8.5v2.8h.1zm-209.6 43.2v-3c0-2 0-4.8-.1-8.4l.1.1c-9.7 0-25.1 0-42.4.1l.2-.2v11.4l-.2-.2c12.1 0 22.7.1 30.2.1 3.8 0 6.8 0 8.9.1h3.1-3c-2.1 0-5.1 0-8.9.1-7.6 0-18.2.1-30.4.1h-.2V254l.2-.2c17.3 0 32.7.1 42.4.1h.1v.1c0 3.6 0 6.5-.1 8.5v2.2c0 .2 0 .4.1.7z"
                    />
                    <path
                        class="st2"
                        d="M99.8 53.1c5.5-6 11.9-11.1 19.2-14.7 20.6-10.4 46-8.7 67.2.7 21.1 9.4 38.5 25.8 52.9 43.9 11.5 14.4 22.3 30.8 39.3 38 22.6 9.5 50-1.4 65.6-20.4 17.3-20.9 36.7-55.6 69.1-39.5 52.1 25.8 14.3 119.8-11.1 150.4-25.6 30.8-62.9 51.1-102.4 58-39.5 6.8-80.8.5-117.4-15.9C132 231.2 89.1 186.9 80 132.7c-3-18-2.3-36.8 4.1-53.9 3.6-9.4 8.9-18.3 15.7-25.7z"
                    />
                    <path
                        d="M99.8 53.1c5.5-6 11.9-11.1 19.2-14.7 20.6-10.4 46-8.7 67.2.7 21.1 9.4 38.5 25.8 52.9 43.9 11.5 14.4 22.3 30.8 39.3 38 22.6 9.5 50-1.4 65.6-20.4 17.3-20.9 36.7-55.6 69.1-39.5 52.1 25.8 14.3 119.8-11.1 150.4-25.6 30.8-62.9 51.1-102.4 58-39.5 6.8-80.8.5-117.4-15.9C132 231.2 89.1 186.9 80 132.7c-3-18-2.3-36.8 4.1-53.9 3.6-9.4 8.9-18.3 15.7-25.7z"
                        opacity=".9"
                        fill="#fff"
                    />
                    <ellipse id="_x3C_Path_x3E__359_" class="st4" cx="265.6" cy="349.1" rx="212.9" ry="12.4" />
                    <path
                        class="st5"
                        d="M402.6 350.9l18.9-145.2h11l32.6 145.2h-3.6l-29.4-129 9.8 129h-4.1l-11.5-129.5-19.1 129.5z"
                    />
                    <path
                        class="st6"
                        d="M402.6 350.9l18.9-145.2h11l32.6 145.2h-3.6l-29.4-129 9.8 129h-4.1l-11.5-129.5-19.1 129.5z"
                    />
                    <path class="st2" d="M367.6 325.8h80.6l18.7-167.9h-80.6z" />
                    <path class="st6" d="M367.6 325.8h80.6l18.7-167.9h-80.6z" />
                    <path
                        class="st6"
                        d="M395.7 202v-17.1l6.9 7.5 18.2-23.4 10.5 23.4 17.1-12.6-10.4 25 10.4 9.4-17.1 5.2 4.9 20.5-18.1-8.3-11.4 19.2-6.9-16.7-11.6 5.3 4-16.2-8.1-4.6 7.6-4.4-4.7-9.4z"
                    />
                    <path
                        class="st2"
                        d="M401.6 202.8c.8-3.5 3.3-5.2 6-4.6 2.6.6 4.1 3.1 3.3 6.5-.8 3.5-3.2 5.3-6 4.7-2.7-.7-4.1-3.3-3.3-6.6zm2.4.5c-.5 2.3.2 3.5 1.4 3.7 1.3.3 2.5-.5 3.1-2.9.5-2.3-.3-3.5-1.4-3.8-1.1-.2-2.5.6-3.1 3zm.5 17l-3.1-.7 17.7-18.7 3.1.7-17.7 18.7zm9-3.8c.8-3.5 3.3-5.2 6-4.6 2.6.6 4.1 3.1 3.3 6.5-.8 3.5-3.2 5.3-6 4.7-2.8-.7-4.1-3.3-3.3-6.6zm2.4.5c-.5 2.3.2 3.5 1.4 3.7 1.3.3 2.5-.5 3.1-2.9.5-2.3-.3-3.5-1.4-3.8-1.2-.3-2.5.5-3.1 3z"
                    />
                    <g class="st7">
                        <path
                            class="st8"
                            d="M401.6 202.8c.8-3.5 3.3-5.2 6-4.6 2.6.6 4.1 3.1 3.3 6.5-.8 3.5-3.2 5.3-6 4.7-2.7-.7-4.1-3.3-3.3-6.6zm2.4.5c-.5 2.3.2 3.5 1.4 3.7 1.3.3 2.5-.5 3.1-2.9.5-2.3-.3-3.5-1.4-3.8-1.1-.2-2.5.6-3.1 3zm.5 17l-3.1-.7 17.7-18.7 3.1.7-17.7 18.7zm9-3.8c.8-3.5 3.3-5.2 6-4.6 2.6.6 4.1 3.1 3.3 6.5-.8 3.5-3.2 5.3-6 4.7-2.8-.7-4.1-3.3-3.3-6.6zm2.4.5c-.5 2.3.2 3.5 1.4 3.7 1.3.3 2.5-.5 3.1-2.9.5-2.3-.3-3.5-1.4-3.8-1.2-.3-2.5.5-3.1 3z"
                        />
                    </g>
                    <path class="st8" d="M394.6 264.9l35.6.4v5.8h-35.6zm-10.5 13.4h57.8v7.4l-60.4-.2z" />
                    <path
                        class="st9"
                        d="M381.5 298.6l-1.7 15.1h14.8v-15.1zm22.4 0l-1.3 15.1h15.5l.1-12.9zm26.3 2.2l-2.6 12.9H439v-12.9z"
                    />
                    <path
                        class="st10"
                        d="M184.2 109.1c10.2-1.8 8.3 34.4 12.3 42.9s28.8 30.5 28.8 30.5 10.8.9 12.5 1.8c1.7.9 1.9 7.2.5 7.2s-13.2.1-14.9-.9c-1.8-.9-2.6-4.7-2.6-4.7s-26.1-15.3-31.5-28.2c-4.5-10.8-8.7-29.5-9.9-36.1-1.2-6.6 2.3-12.1 4.8-12.5z"
                    />
                    <path
                        class="st2"
                        d="M77.3 239.3s6.4-6.4 16.8 2 15.9 20 33.7 13.9c17.8-6.1 45 11 50.5-1.3 0 0-9.2-24.2-27.2-31.7s-64.6 10.2-73.8 17.1z"
                    />
                    <path
                        class="st10"
                        d="M136.5 203.1c-.2 4-.6 12.7-1.4 21.7-1 12-2.7 24.5-5.2 26.7-.3.2-.5.5-.9.8-1.2 1-3 2.4-5.2 4-5.5 4-13.7 9.7-22.5 15.6-1.2.9-2.5 1.7-3.8 2.5-6.6 4.5-13.5 9-19.7 13.2-2.5 1.6-4.8 3.2-7.1 4.7C60 299.4 52 304.5 52 304.5l3.5 5s3.9-2.3 11.3-5.3c2.1-.9 4.3-1.8 6.6-2.9 4.7-2.1 9.8-4.6 15.2-7.3 1.6-.8 3.2-1.6 4.9-2.4 11.9-6 24.7-12.9 35.1-19.7 6.2-4 11.7-8 15.6-11.7 3.2-3.1 5.4-5.9 6.2-8.5 2.3-7.6 4.5-19.8 6.1-31.7.8-5.9 1.5-11.8 2.1-17.1l-22.1.2z"
                    />
                    <path
                        class="st2"
                        d="M53.9 301.6c.8-.2 2.3 9.6 2.3 9.6s-4.7 7.3-4.7 13.3c0 6-4.2 3.6-5.7-2.8-1.4-6.4-2.6-11.3-3.6-15.8-1-4.6 3.5-2.6 11.7-4.3z"
                    />
                    <path
                        class="st7"
                        d="M160.5 184.2s-1.5 17.7-4 36c-1.6 11.9-3.8 24.1-6.1 31.7-.8 2.5-2.9 5.4-6.2 8.5-3.9 3.7-9.3 7.6-15.6 11.7-1.9-5.4-3.5-10.9-4.8-15.8 2.2-1.6 4-2.9 5.2-4 .3-.3.6-.5.9-.8 2.5-2.3 4.2-14.7 5.2-26.7 1-12.2 1.4-23.9 1.4-23.9l24-16.7z"
                    />
                    <path
                        class="st5"
                        d="M164.4 167.8l-33.6-5.5c1 .2 7.6-14.3 9-19.4 2.1-7.1 3.6-20.7 2.3-29.5v-.1c-.6-3.8 2.1-7.2 5.9-7.5 2.7-.2 5.4-.3 8.1-.3 5.3-.1 10.7.2 15.9.9 6.8 1.1 14.5 3.1 14.5 3.1s1 .5.6 7.8c-.5 6.8-3.1 29.2-22.7 50.5z"
                    />
                    <path
                        class="st10"
                        d="M176.9 99.6s-4.3 2.8-5.1 4.7c0 .1-.1.2-.1.3-.3 1-.4 3.2-.4 3.2 1.3 3.7-3.5 5.8-3.5 5.8-8.4-2.5-10.4-6.6-10.4-6.6 6.9-2.7 8.3-16 8.3-16l3.4 2.6 7.8 6zm6.6 199.1l-8.8-19.7-12-26.8-2.1-4.7-9.3-20.3-11.1-24.1H115c3.3 11.2 9.9 23.6 16.8 34.5 6.7 10.7 13.7 20 18 25.5 2.6 3.3 4.2 5.2 4.2 5.2 5 11.6 11.4 23.6 17.6 34.3 2.6 4.4 5 8.5 7.4 12.4 8.8 14.3 15.9 24.2 15.9 24.2l5.4-3.3-16.8-37.2z"
                    />
                    <path
                        class="st2"
                        d="M191.1 336.4c-.3-.7 8.9-4.2 8.9-4.2s8 3.2 13.9 2.1 4.3 3.5-1.7 6.1-10.6 4.7-14.9 6.6c-4.1 1.9-3.1-2.9-6.2-10.6zm-60.3-174.2s-18.3 9.1-19.4 33.6c-.6 13.6-34.2 43.5-34.2 43.5s1.4 4.9 10.8 5.2c9.4.3 27.1-10.1 39.6-7.3 12.5 2.9 11.3 7.5 21.1 5.5 9.9-2 20 .5 29.5 11.1 0 0 4.3-35.2-14.1-61.2 0 0-1.4-6.9.2-24.9l-33.5-5.5z"
                    />
                    <path
                        class="st6"
                        d="M130.8 162.2s-18.3 9.1-19.4 33.6c-.6 13.6-34.2 43.5-34.2 43.5s1.4 4.9 10.8 5.2c9.4.3 27.1-10.1 39.6-7.3 12.5 2.9 11.3 7.5 21.1 5.5 9.9-2 20 .5 29.5 11.1 0 0 4.3-35.2-14.1-61.2 0 0-1.4-6.9.2-24.9l-33.5-5.5z"
                    />
                    <path class="st2" d="M131.6 160.4l32.8 7.4-.4 5.9-36.2-9.5z" />
                    <path
                        class="st7"
                        d="M154.6 167.6c0 1.2-1 2.2-2.2 2.2-1.2 0-2.2-1-2.2-2.2s1-2.2 2.2-2.2c1.2 0 2.2 1 2.2 2.2zm22.3-68s-4.3 2.8-5.1 4.7c0 .1-.1.2-.1.3-6.3-4.8-5.5-12-5.5-12l2.8 1 7.9 6z"
                    />
                    <path class="st11" d="M182.5 67.5s8.7-2.4 13 4.6c4.2 7.1.9 12.4-2.1 15" />
                    <path
                        class="st5"
                        d="M185.3 68s7.1.2 9.1 6.2.5 12.8-10.1 20.1c-10.6 7.3-19.6.3-23.7-4.6-4.2-4.9-3.1-21 8.5-24.2 12-3.3 16.2 2.5 16.2 2.5z"
                    />
                    <path
                        class="st10"
                        d="M178.5 70c9.1 1.2 11.3 6.5 10.7 15.9-.8 11.8-4.5 19.7-15.5 15.7-14.9-5.5-10.3-33.6 4.8-31.6z"
                    />
                    <path d="M183.4 84.6s.9 2.5 2.1 4.1c0 0-.9 1.1-2.5.7l.4-4.8z" fill="#d58745" />
                    <path
                        class="st5"
                        d="M177.9 83.2c-.1.7-.5 1.3-1 1.2-.5 0-.8-.7-.7-1.4s.5-1.3 1-1.2c.5 0 .8.6.7 1.4z"
                    />
                    <path
                        class="st5"
                        d="M177 81.7l1.7-.5c0 .1-1 1.3-1.7.5zm10.2 2.3c-.1.7-.5 1.3-1 1.2-.5 0-.8-.7-.7-1.4.1-.7.5-1.3 1-1.2.5 0 .8.7.7 1.4z"
                    />
                    <path class="st5" d="M186.3 82.6l1.7-.5s-1 1.3-1.7.5z" />
                    <path
                        d="M178.7 76.9s-2.5-.7-4.1.9m10.7-.4s1.7-.4 3.5 1.2"
                        fill="none"
                        stroke="#263238"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-miterlimit="10"
                        stroke-width=".708"
                    />
                    <path
                        class="st5"
                        d="M166.5 84s5.2-6.9 5.4-12.7c0 0 18.9-4.9 17.3 13.5 0 0 4-15.9-11.6-18.4-15.5-2.5-18.5 20.3-11.4 28.2 0-.1-3-6.3.3-10.6z"
                    />
                    <path class="st10" d="M167.7 86.1c.2-1.5-1-4.2-3.8-4.2-2.8-.1-5 5.5 1.8 7.8 1 .3 1.7-.6 2-3.6z" />
                    <path
                        class="st5"
                        d="M167.2 67.4s-.8-4.6-6-7.8-10.9-1.2-15.6 9.4c-4.8 10.6-11.7 8.3-14.8 5.7 0 0 1 5 8.1 7.2 7.1 2.1 11.1-1.5 14.5-7.4s9.2-3.3 9.2-3.3l4.6-3.8zm15.3 24.8c-.5 1.2-.9 3.3-.9 3.3h-.6c-2.7-.1-4-1.1-4.5-2.1-.3-.6-.3-1.2-.3-1.6 0-.5.1-.9.1-.9 1.4.9 4 1.2 5.3 1.4.5-.1.9-.1.9-.1z"
                    />
                    <path
                        class="st8"
                        d="M181.6 92.1l-.3 1c-2.6-.1-4.4-.5-5.2-1.4 0-.5.1-.9.1-.9 1.4.9 4 1.2 5.4 1.3z"
                    />
                    <path d="M181 95.5c-2.7-.1-4-1.1-4.5-2.1.9.1 2.1.3 3 .7.7.3 1.2.8 1.5 1.4z" fill="#de5753" />
                    <path class="st11" d="M163.5 70.3s-2.8-2.8-6.4.6c-3.6 3.4-3.9 10.9-9.7 13" />
                    <path
                        class="st2"
                        d="M156.5 93.2c.3 0 .5-.2.7-.4l3.1-4.4c.3-.4.2-.9-.2-1.3l-4.2-3.6c-.2-.2-.5-.2-.7-.2L145 84.5c-.5.1-.9.5-.8 1l.4 7.8c0 .5.5.9 1 .9l10.9-1zm1.6-5.2c0-.3.3-.7.6-.7s.7.3.7.6-.3.7-.6.7c-.4.1-.7-.2-.7-.6z"
                    />
                    <path
                        class="st8"
                        d="M151.7 85.4c1 0 1.7.6 1.7 1.4s-.6 1.4-1.6 1.4-1.7-.5-1.7-1.4c-.1-.8.5-1.3 1.6-1.4zm0 .8c-.7 0-1 .3-1 .7 0 .4.3.7 1.1.7.7 0 1-.3 1-.7-.1-.4-.4-.7-1.1-.7zm-4.9 1.3v-1l6.6 3.8v1l-6.6-3.8zm1.7 2.3c1 0 1.7.6 1.7 1.4 0 .8-.6 1.4-1.6 1.4s-1.7-.5-1.7-1.4c0-.8.6-1.4 1.6-1.4zm.1.8c-.7 0-1 .3-1 .7 0 .4.3.7 1.1.7.7 0 1-.3 1-.7-.1-.4-.4-.8-1.1-.7z"
                    />
                    <path
                        d="M159.4 88s6.8-3.3 6.9-8.9"
                        fill="none"
                        stroke="#fff"
                        stroke-width=".5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-miterlimit="10"
                    />
                    <path
                        class="st2"
                        d="M165.2 78.6l7.3-13.8s10 .4 17.9 1.9c0 0 2.8 2.2 1.2 3.6s-4.9.4-5.9-.4-1.5-2.9-1.5-2.9l-1.7-.2s1.6 3.6-.9 3.6c-2.6-.1-7.3-1.7-8.2-4.1l-7.9 14-.3-1.7z"
                    />
                    <path
                        class="st10"
                        d="M145 106.5c12.5-1.9 13.6 36.7 18.5 45.6 4.9 9 35.4 32.1 35.4 32.1s10-.9 12.1 0c2.1.9 2.3 7.6.6 7.6s-12.8 2-15.1 1c-2.2-1-3.3-4.9-3.3-4.9s-32.1-16.1-38.7-29.7c-5.5-11.3-10.7-31-12.2-37.9-1.4-7-.5-13.3 2.7-13.8z"
                    />
                    <path
                        class="st2"
                        d="M162.6 127.2l6.2 11.9c.5 1 2 1.1 2.7.2l7.8-10.7c.7-1 .1-2.4-1.1-2.5l-14.1-1.3c-1.3 0-2.1 1.3-1.5 2.4z"
                    />
                    <path
                        class="st8"
                        d="M161.6 131.8v.3c0 .9.7 1.6 1.5 1.6l14.5.7c.8 0 1.5-.5 1.6-1.3.2-.9-.5-1.8-1.5-1.8l-14.5-1c-.8-.1-1.6.6-1.6 1.5z"
                    />
                    <path
                        class="st2"
                        d="M338.5 141.3c.1.6.4 1.1.9 1.4l9.7 6.5c.9.6 2.1.4 2.7-.4l7.6-9.4c.3-.4.5-1 .4-1.6l-3.3-22c-.2-1-1.1-1.8-2.2-1.7l-16.9 1.4c-1.2.1-2 1.1-1.9 2.3l3 23.5zm11.4 3.3c.8 0 1.4.5 1.4 1.3s-.5 1.4-1.3 1.4-1.4-.5-1.4-1.3c-.1-.7.5-1.4 1.3-1.4z"
                    />
                    <path
                        class="st6"
                        d="M338.5 141.3c.1.6.4 1.1.9 1.4l9.7 6.5c.9.6 2.1.4 2.7-.4l7.6-9.4c.3-.4.5-1 .4-1.6l-3.3-22c-.2-1-1.1-1.8-2.2-1.7l-16.9 1.4c-1.2.1-2 1.1-1.9 2.3l3 23.5zm11.4 3.3c.8 0 1.4.5 1.4 1.3s-.5 1.4-1.3 1.4-1.4-.5-1.4-1.3c-.1-.7.5-1.4 1.3-1.4z"
                    />
                    <path
                        class="st2"
                        d="M355.1 130.4c.1 2.3-1.2 3.8-2.9 3.9-1.7.1-3.1-1.2-3.1-3.5-.1-2.3 1-3.8 2.9-3.9 1.7-.1 3 1.3 3.1 3.5zm-1.6 0c-.1-1.5-.7-2.1-1.5-2.1-.9 0-1.5.7-1.4 2.4.1 1.5.8 2.1 1.6 2.1.7 0 1.4-.8 1.3-2.4zm-3.2-10.4l2.1-.1-7.7 14.5-2.1.1 7.7-14.5zm-4.9 3.9c.1 2.3-1.2 3.8-2.9 3.9-1.7.1-3.1-1.2-3.1-3.5-.1-2.3 1-3.8 2.9-3.9 1.8 0 3 1.4 3.1 3.5zm-1.5.1c-.1-1.5-.7-2.1-1.5-2.1-.9 0-1.5.7-1.4 2.4.1 1.5.8 2.1 1.5 2.1s1.4-.8 1.4-2.4z"
                    />
                    <path class="st16" d="M350.1 146s.4 25.1-16.5 30.7" />
                    <path
                        class="st2"
                        d="M299.2 169.1h-.2c-.4-.1-10.4-1.9-13.1-6.4-.8-1.3-.9-2.7-.5-4.1s1.9-3.3 6.1-3.8c7.1-.9 19.1 2.6 21.3 6.2.2.4.1.9-.3 1.1s-.9.1-1.1-.3c-1.7-2.8-12.8-6.3-19.7-5.5-1.9.2-4.2.9-4.8 2.6-.3 1-.2 1.9.3 2.8 2.3 3.9 11.9 5.7 11.9 5.7.5.1.7.5.7 1 .2.4-.2.7-.6.7z"
                    />
                    <path class="st2" d="M338.5 157.1l10.6 67.3-33.6 10.4-16.7-4-5.4-61.9 15-10.2z" />
                    <path opacity=".2" fill="#fff" d="M315.5 234.8l-7.1-76.1-15 10.2 5.4 61.9z" />
                    <path
                        class="st2"
                        d="M315.5 163.5c-.2 0-.4-.1-.6-.3-.3-.3-6.2-6.6-5.9-12.7.1-2.3 1-4.2 2.8-5.7 2.1-1.9 4.8-2.3 7.8-1.2 6.4 2.3 13.2 11.3 14 16.6.1.5-.2.9-.7.9-.5.1-.9-.2-.9-.7-.7-4.9-7.1-13.2-12.9-15.3-2.4-.9-4.5-.6-6.1.9-1.4 1.2-2.1 2.7-2.2 4.5-.2 5.4 5.4 11.5 5.4 11.5.3.3.3.9 0 1.2-.4.2-.6.3-.7.3z"
                    />
                    <g class="st7">
                        <path
                            class="st8"
                            d="M315.5 163.5c-.2 0-.4-.1-.6-.3-.3-.3-6.2-6.6-5.9-12.7.1-2.3 1-4.2 2.8-5.7 2.1-1.9 4.8-2.3 7.8-1.2 6.4 2.3 13.2 11.3 14 16.6.1.5-.2.9-.7.9-.5.1-.9-.2-.9-.7-.7-4.9-7.1-13.2-12.9-15.3-2.4-.9-4.5-.6-6.1.9-1.4 1.2-2.1 2.7-2.2 4.5-.2 5.4 5.4 11.5 5.4 11.5.3.3.3.9 0 1.2-.4.2-.6.3-.7.3z"
                        />
                    </g>
                    <path
                        class="st2"
                        d="M276 213.1c-.5 0-1-.2-1.5-.5l-28.3-18.7c-.5-.3-1.2-.5-1.8-.5H192l18.6 14.8c1.2.9 1.4 2.7.4 3.8-.9 1.2-2.7 1.4-3.8.4l-24.8-19.7c-.9-.7-1.3-1.9-.9-3.1.4-1.1 1.4-1.8 2.6-1.8h60.3c1.7 0 3.4.5 4.8 1.4l28.3 18.7c1.3.9 1.6 2.5.8 3.8-.5 1-1.4 1.4-2.3 1.4z"
                    />
                    <path
                        d="M276 213.1c-.5 0-1-.2-1.5-.5l-28.3-18.7c-.5-.3-1.2-.5-1.8-.5H192l18.6 14.8c1.2.9 1.4 2.7.4 3.8-.9 1.2-2.7 1.4-3.8.4l-24.8-19.7c-.9-.7-1.3-1.9-.9-3.1.4-1.1 1.4-1.8 2.6-1.8h60.3c1.7 0 3.4.5 4.8 1.4l28.3 18.7c1.3.9 1.6 2.5.8 3.8-.5 1-1.4 1.4-2.3 1.4z"
                    />
                    <path class="st2" d="M217.7 254.8l35.8-79.4 37-5.2 8.7 13.4-14.8 88.8-41.8 3.5z" />
                    <path class="st6" d="M217.7 254.8l35.8-79.4 37-5.2 8.7 13.4-14.8 88.8-41.8 3.5z" />
                    <path class="st7" d="M290.5 170.2l-22.6 75.1-50.2 9.5 24.9 21.1 41.8-3.5 14.8-88.8z" />
                    <path class="st7" d="M217.7 254.8l50.2-9.5 16.5 27.1-41.8 3.5z" />
                    <path
                        class="st5"
                        d="M262.4 185.3h-.8c-4-.1-6.2-1-6.7-2.8-.9-3.1 4.4-7 5.4-7.8.4-.3.9-.2 1.2.2.3.4.2.9-.2 1.2-2.3 1.6-5.2 4.5-4.8 6 .1.4.9 1.5 5.2 1.6 12.4.4 18.3-9.9 18.3-10 .2-.4.7-.5 1.1-.3s.5.7.3 1.1c0 .1-6.1 10.8-19 10.8zm24.3 92.9l-2.3-79.6 40.4-7 18.7 7-2.8 72.6-18.9 9.5z"
                    />
                    <path class="st9" d="M324.8 191.6l-3 89.1 18.9-9.5 2.8-72.6z" />
                    <path
                        class="st2"
                        d="M304.1 219.6c-2.2 0-4.1-.8-5.6-2.3-4.9-5-4.3-16.3-4.2-16.8s.4-.8.9-.8.8.4.8.9c0 .1-.6 11.1 3.8 15.6 1.3 1.3 2.8 1.9 4.7 1.8 1.7-.1 3.1-.7 4.2-2.1 4.7-5.4 3.4-18.9 3.4-19 0-.5.3-.9.7-.9.5-.1.9.3.9.7 0 .6 1.4 14.4-3.8 20.3-1.4 1.7-3.3 2.6-5.4 2.6h-.4z"
                    />
                    <path
                        d="M304.1 219.6c-2.2 0-4.1-.8-5.6-2.3-4.9-5-4.3-16.3-4.2-16.8s.4-.8.9-.8.8.4.8.9c0 .1-.6 11.1 3.8 15.6 1.3 1.3 2.8 1.9 4.7 1.8 1.7-.1 3.1-.7 4.2-2.1 4.7-5.4 3.4-18.9 3.4-19 0-.5.3-.9.7-.9.5-.1.9.3.9.7 0 .6 1.4 14.4-3.8 20.3-1.4 1.7-3.3 2.6-5.4 2.6h-.4z"
                    />
                    <path
                        class="st5"
                        d="M361.7 339.2c-1.9-3.3-6.8-4.1-10.9-1.7-4.1 2.4-5.9 7-4 10.3 1.9 3.3 6.8 4.1 10.9 1.7 4.1-2.4 5.9-7 4-10.3zm-103.2-1.7c-4.1 2.4-5.9 7-4 10.3 1.9 3.3 6.8 4.1 10.9 1.7 4.1-2.4 5.9-7 4-10.3-1.9-3.3-6.7-4.1-10.9-1.7z"
                    />
                    <path
                        class="st2"
                        d="M349.6 340.9h-89.5c-1.5 0-2.8-1.2-2.8-2.8 0-1.5 1.2-2.8 2.8-2.8h89.5c.9 0 1.7-.7 1.7-1.7v-7.1c0-.8-.5-1.5-1.3-1.6l-74-16c-6.6-1.4-11.4-7.4-11.4-14.2v-13.9c0-1.5 1.2-2.8 2.8-2.8 1.5 0 2.8 1.2 2.8 2.8v13.9c0 4.2 3 7.9 7.1 8.8l74 16c3.3.7 5.6 3.6 5.6 7v7.1c-.2 4.1-3.3 7.3-7.3 7.3z"
                    />
                    <path
                        d="M349.6 340.9h-89.5c-1.5 0-2.8-1.2-2.8-2.8 0-1.5 1.2-2.8 2.8-2.8h89.5c.9 0 1.7-.7 1.7-1.7v-7.1c0-.8-.5-1.5-1.3-1.6l-74-16c-6.6-1.4-11.4-7.4-11.4-14.2v-13.9c0-1.5 1.2-2.8 2.8-2.8 1.5 0 2.8 1.2 2.8 2.8v13.9c0 4.2 3 7.9 7.1 8.8l74 16c3.3.7 5.6 3.6 5.6 7v7.1c-.2 4.1-3.3 7.3-7.3 7.3z"
                    />
                    <path
                        class="st2"
                        d="M349.5 246.3v-.2l3.2-17.7 3.3-18.2c.2-.8-.1-1.6-.6-2.3s-1.3-1-2.1-1h-34.9c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h10l-1.7 12.6h-75.2c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h74.4l-1.7 12.3H256c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h67.4l-1.8 12.8h-61.2c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h60.4l-1.6 11.5h-7.1c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h28.3c1.3 0 2.5-.9 2.7-2.3l3.1-17 3.3-18.5zm-4.9-3.4h-3.8l2.2-12.3h3.9l-2.3 12.3zm-1.1 5.5l-2.3 12.8h-3.7l2.3-12.8h3.7zm4.3-23.3h-3.9l2.2-12.6h4l-2.3 12.6zM334 212.5h6.5l-2.2 12.6h-6.1l1.8-12.6zm-2.5 18.1h5.9l-2.2 12.3h-5.4l1.7-12.3zm-2.5 17.8h5.2l-2.3 12.8h-4.7l1.8-12.8zm-2.6 18.3h4.5l-2 11.5h-4.2l1.7-11.5zm8.1 11.5l2-11.5h3.7l-2.1 11.5h-3.6z"
                    />
                    <path
                        d="M349.5 246.3v-.2l3.2-17.7 3.3-18.2c.2-.8-.1-1.6-.6-2.3s-1.3-1-2.1-1h-34.9c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h10l-1.7 12.6h-75.2c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h74.4l-1.7 12.3H256c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h67.4l-1.8 12.8h-61.2c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h60.4l-1.6 11.5h-7.1c-1.5 0-2.8 1.2-2.8 2.8 0 1.5 1.2 2.8 2.8 2.8h28.3c1.3 0 2.5-.9 2.7-2.3l3.1-17 3.3-18.5zm-4.9-3.4h-3.8l2.2-12.3h3.9l-2.3 12.3zm-1.1 5.5l-2.3 12.8h-3.7l2.3-12.8h3.7zm4.3-23.3h-3.9l2.2-12.6h4l-2.3 12.6zM334 212.5h6.5l-2.2 12.6h-6.1l1.8-12.6zm-2.5 18.1h5.9l-2.2 12.3h-5.4l1.7-12.3zm-2.5 17.8h5.2l-2.3 12.8h-4.7l1.8-12.8zm-2.6 18.3h4.5l-2 11.5h-4.2l1.7-11.5zm8.1 11.5l2-11.5h3.7l-2.1 11.5h-3.6z"
                    />
                    <path
                        class="st2"
                        d="M320.5 207.8c-.5-.6-1.2-.9-2-.9H206.7c-.9 0-1.6.4-2.1 1-.5.7-.7 1.5-.5 2.3l4.1 18.1 12.1 53.2c.3 1.2 1.4 2.1 2.7 2.1h89.2c1.4 0 2.6-1.1 2.7-2.5l6.3-71.2c.1-.7-.2-1.5-.7-2.1zm-9.4 53.4h-12.7l.5-12.7h13.3l-1.1 12.7zm-70.6 17l-1.5-11.5h13.7l.9 11.5h-13.1zm16-35.2l-.9-12.3h18.1V243h-17.2zm17.2 5.4v12.7h-15.9l-.9-12.7h16.8zm5.4-17.8h15.1l-.5 12.3h-14.6v-12.3zm0-5.5v-12.6H295l-.5 12.6h-15.4zm-5.4 0h-18.5l-.9-12.6h19.4v12.6zm-24 0h-16.1l-1.6-12.6h16.8l.9 12.6zm.4 5.5l.9 12.3h-15.1l-1.6-12.3h15.8zM230.4 243h-13.3l-2.8-12.3h14.5l1.6 12.3zm-12 5.4h12.7l1.6 12.7h-11.4l-2.9-12.7zm18.2 0h14.7l.9 12.7h-14l-1.6-12.7zm21.6 18.3h15.5v11.5H259l-.8-11.5zm20.9 0h13.5l-.5 11.5h-13v-11.5zm0-5.5v-12.7h14.4l-.5 12.7h-13.9zm20.1-18.2l.5-12.3h14.1l-1.1 12.3h-13.5zm15.1-17.9H300l.5-12.6h14.9l-1.1 12.6zm-87.8-12.6l1.6 12.6h-15l-2.9-12.6h16.3zm-4 54.2h10.9l1.5 11.5h-9.8l-2.6-11.5zm75.2 11.5l.5-11.5h12.5l-1 11.5h-12z"
                    />
                    <path
                        class="st2"
                        d="M305.7 340.9h-89.5c-1.5 0-2.8-1.2-2.8-2.8 0-1.5 1.2-2.8 2.8-2.8h89.5c.9 0 1.7-.7 1.7-1.7v-7.1c0-.8-.5-1.5-1.3-1.6l-74-16c-6.6-1.4-11.4-7.4-11.4-14.2v-13.9c0-1.5 1.2-2.8 2.8-2.8 1.5 0 2.8 1.2 2.8 2.8v13.9c0 4.2 3 7.9 7.1 8.8l74 16c3.3.7 5.6 3.6 5.6 7v7.1c-.2 4.1-3.4 7.3-7.3 7.3z"
                    />
                    <ellipse
                        transform="rotate(-30 305.901 343.535)"
                        class="st5"
                        cx="305.9"
                        cy="343.5"
                        rx="8.6"
                        ry="6.9"
                    />
                    <path
                        class="st2"
                        d="M308 341.2c.9 1.6.1 3.9-1.9 5-2 1.2-4.4.8-5.4-.8-.9-1.6-.1-3.9 1.9-5 2-1.3 4.4-.9 5.4.8z"
                    />
                    <ellipse
                        transform="rotate(-30 213.679 343.528)"
                        class="st5"
                        cx="213.7"
                        cy="343.5"
                        rx="8.6"
                        ry="6.9"
                    />
                    <path
                        class="st2"
                        d="M215.7 341.2c.9 1.6.1 3.9-1.9 5-2 1.2-4.4.8-5.4-.8-.9-1.6-.1-3.9 1.9-5 2.1-1.3 4.5-.9 5.4.8zm37.4-186c.5.3 1.1.4 1.7.3l11.3-3.1c1-.3 1.7-1.3 1.5-2.3l-2.2-11.9c-.1-.5-.4-1-.9-1.4L245.6 125c-.9-.6-2.1-.3-2.7.5l-9.9 13.7c-.7.9-.4 2.3.5 2.9l19.6 13.1zm9.9-6.5c.5-.6 1.4-.7 1.9-.2.6.5.7 1.4.2 1.9-.5.6-1.4.7-1.9.2-.6-.4-.7-1.3-.2-1.9z"
                    />
                    <path
                        class="st8"
                        d="M255.6 135.5c1.8 1.4 2.1 3.4 1 4.7-1 1.4-2.9 1.5-4.7.2-1.8-1.4-2.2-3.3-1.1-4.7 1.2-1.5 3.1-1.6 4.8-.2zm-1 1.3c-1.2-.9-2.1-.8-2.6-.2-.5.7-.4 1.6.9 2.6 1.2.9 2.1.8 2.6.2.5-.7.4-1.6-.9-2.6zm-10-4.4l1.3-1.6 6 15.4-1.3 1.6-6-15.4zm-.2 6.3c1.8 1.4 2.1 3.4 1 4.7-1 1.4-2.9 1.5-4.7.2-1.8-1.4-2.2-3.3-1-4.7 1.1-1.5 3-1.6 4.7-.2zm-1 1.2c-1.2-.9-2.1-.8-2.6-.2-.5.7-.4 1.6.9 2.6 1.2.9 2.1.8 2.6.2.5-.6.4-1.6-.9-2.6z"
                    />
                    <path
                        class="st2"
                        d="M320.1 226.2c-.2-.5-.7-.9-1.3-1.1l-11.2-3.2c-1-.3-2.1.2-2.5 1.2l-4.3 11.3c-.2.5-.2 1.1.1 1.6l10 20c.5 1 1.6 1.4 2.6 1l15.6-6.5c1.1-.4 1.6-1.7 1-2.8l-10-21.5zm-11.8.3c-.7.3-1.5-.1-1.8-.8-.3-.7.1-1.5.8-1.8.7-.3 1.5.1 1.8.8.3.8-.1 1.5-.8 1.8z"
                    />
                    <path
                        class="st6"
                        d="M320.1 226.2c-.2-.5-.7-.9-1.3-1.1l-11.2-3.2c-1-.3-2.1.2-2.5 1.2l-4.3 11.3c-.2.5-.2 1.1.1 1.6l10 20c.5 1 1.6 1.4 2.6 1l15.6-6.5c1.1-.4 1.6-1.7 1-2.8l-10-21.5zm-11.8.3c-.7.3-1.5-.1-1.8-.8-.3-.7.1-1.5.8-1.8.7-.3 1.5.1 1.8.8.3.8-.1 1.5-.8 1.8z"
                    />
                    <path
                        class="st5"
                        d="M307.7 241.6c-.8-2.1 0-4 1.6-4.6 1.6-.6 3.3.3 4.1 2.3.8 2.1.2 4-1.6 4.6-1.8.7-3.4-.2-4.1-2.3zm1.4-.5c.5 1.4 1.3 1.8 2.1 1.5.8-.3 1.2-1.1.6-2.7-.5-1.4-1.4-1.8-2.1-1.5-.7.3-1.1 1.1-.6 2.7zm6.3 8.9l-1.9.7 2.9-16.2 1.9-.7-2.9 16.2zm3.4-5.2c-.8-2.1 0-4 1.6-4.6 1.6-.6 3.3.3 4.1 2.3.8 2.1.2 4-1.6 4.6-1.7.6-3.3-.3-4.1-2.3zm1.5-.6c.5 1.4 1.3 1.8 2.1 1.5.8-.3 1.2-1.1.6-2.7-.5-1.4-1.4-1.8-2.1-1.5-.7.3-1.2 1.2-.6 2.7zM215 224.1c.9-.4 1.5-1.1 1.7-2l5.2-17.4c.5-1.6-.3-3.3-1.9-3.9l-17.5-6.9c-.8-.3-1.7-.3-2.6.1l-31.3 15.2c-1.5.7-2.2 2.5-1.6 4.1l9.9 24.4c.7 1.7 2.6 2.4 4.3 1.7l33.8-15.3zm-.3-18.5c-.4-1.1.2-2.4 1.3-2.8 1.1-.4 2.4.2 2.8 1.3.4 1.1-.2 2.4-1.3 2.8-1.1.4-2.4-.1-2.8-1.3z"
                    />
                    <path
                        class="st8"
                        d="M191.1 204.5c3.3-1.2 6.2 0 7.1 2.5.9 2.5-.5 5.1-3.6 6.3-3.3 1.2-6.2.2-7.2-2.5-.9-2.6.5-5.2 3.7-6.3zm.9 2.3c-2.3.8-2.8 2.1-2.4 3.2.5 1.2 1.7 1.9 4.2 1 2.2-.8 2.8-2.2 2.4-3.3-.5-1.1-1.9-1.8-4.2-.9zm-14 9.6l-1.1-3 25.3 4.7 1.1 3-25.3-4.7zm8.1 5.5c3.3-1.2 6.2 0 7.1 2.5s-.5 5.1-3.6 6.3c-3.3 1.2-6.2.2-7.2-2.5s.4-5.2 3.7-6.3zm.8 2.3c-2.3.8-2.8 2.1-2.4 3.2.5 1.2 1.7 1.9 4.2 1 2.2-.8 2.8-2.2 2.4-3.3-.4-1.1-1.8-1.8-4.2-.9z"
                    />
                    <path class="st18" d="M217.7 204s35.4-7.1 40.8-21.9" />
                    <path class="st16" d="M265.2 150.4s11.4 11.9 23 8.3" />
                    <path class="st18" d="M307.8 225.1s-3-2.5-2.4-8.4" />
                    <path
                        class="st4"
                        d="M437.9 340.8c-11.8-9.3-13.6-25.4-12.3-39.7.2-2.4.1-4.9 1.4-6.9s4-3.3 6.1-2.2c1.7.9 2.4 3 3.3 4.8 1.2 2.3 3 4.3 5.3 5.7 1.5.9 3.3 1.5 4.9.7 2.1-1 2.5-3.9 2.7-6.2.2-4.4.5-8.9.7-13.3.1-2.4.3-4.8 1.1-7 .9-2.2 2.6-4.2 4.9-4.7s5 1 5.4 3.3c.1 1-.1 2-.1 3s.4 2.1 1.3 2.4 1.9-.3 2.7-.9c2.6-2.3 4.4-5.3 6.2-8.2 1.7-3 3.4-6 5.8-8.5s5.6-4.4 9-4.4 6.9 2.3 7.6 5.7c.7 3.4-1.5 6.7-3.8 9.3-3.4 3.8-7.3 7.2-11.7 9.9-.8.5-1.6 1-2 1.9-.6 1.6.8 3.2 2.3 3.8 1.7.7 3.7.6 5.5.9s3.8 1.3 4.4 3.1c.8 2.5-1.3 4.9-3.4 6.5-4.2 3.1-8.9 5.5-13.9 7-1.8.5-3.7 1-5.1 2.1-1.5 1.1-2.5 3.2-1.7 5 .8 1.7 2.9 2.4 4.8 2.2 1.8-.2 3.5-1.1 5.3-1.7 3.3-1 7.5-.6 9.5 2.4 1.3 1.9 1.2 4.5.4 6.7-.8 2.2-2.3 4-3.9 5.7-5.6 5.8-12.6 10.4-20.3 12.6-7.9 1.9-15 2.2-22.4-1"
                    />
                    <path
                        class="st0"
                        d="M442.1 332.1c2.5-7.1 5.9-14.7 9.8-22.4 1-1.9 1.9-3.9 2.9-5.7.9-1.9 1.9-3.8 2.9-5.5 2-3.6 4.3-6.8 6.5-9.8s4.4-5.8 6.5-8.4 4.1-5 6-7.1c3.8-4.2 7.3-7.2 9.8-9.2 1.2-1 2.2-1.7 2.9-2.2.3-.2.6-.4.8-.6.2-.1.3-.2.3-.2l-.2.2c-.2.1-.4.3-.7.6-.7.5-1.6 1.3-2.8 2.3-2.4 2-5.9 5.1-9.6 9.3-1.9 2.1-3.9 4.5-6 7.1s-4.3 5.4-6.5 8.4-4.4 6.3-6.5 9.8c-1 1.8-1.9 3.6-2.9 5.5-.9 1.9-1.9 3.8-2.9 5.7-3.8 7.8-7.3 15.3-9.8 22.4"
                    />
                    <path
                        class="st0"
                        d="M457.8 298.4s-.1-.4-.2-1c-.1-.7-.2-1.6-.3-2.8-.2-2.4-.4-5.7-.5-9.3-.2-3.6-.4-6.9-.6-9.3-.1-1.2-.2-2.1-.3-2.8-.1-.7-.1-1-.1-1s.1.4.2 1c.1.7.3 1.6.4 2.8.3 2.4.6 5.7.7 9.3.2 3.6.3 6.8.4 9.3.1 1.1.1 2.1.1 2.8.3.6.3 1 .2 1z"
                    />
                    <path
                        class="st0"
                        d="M488.7 294.4s-.4.1-1.2.1c-.8 0-1.9.1-3.3.1-2.8.1-6.7.5-11 1-4.3.6-8.1 1.2-10.9 1.8-1.4.3-2.5.5-3.3.7s-1.2.3-1.2.2c0 0 .4-.2 1.2-.4.8-.2 1.9-.5 3.2-.8 2.8-.6 6.6-1.4 10.9-1.9 4.3-.6 8.2-.8 11-.9h3.3c.9.1 1.3.1 1.3.1zm-46.1 37.1s-.1-.1-.2-.4-.3-.7-.5-1.1c-.4-1-.9-2.4-1.6-4.2-1.3-3.6-2.9-8.6-4.6-14.1-1.7-5.6-3.2-10.6-4.4-14.2-.6-1.8-1.1-3.2-1.4-4.3-.2-.5-.3-.8-.4-1.2-.1-.3-.1-.4-.1-.4s.1.1.2.4.3.7.5 1.1c.4 1 .9 2.4 1.6 4.2 1.3 3.6 2.9 8.6 4.6 14.1 1.7 5.6 3.2 10.6 4.4 14.2.6 1.8 1.1 3.2 1.4 4.3.2.5.3.8.4 1.2 0 .3.1.4.1.4zm41.3-10.7s-.1.1-.4.1c-.3.1-.7.2-1.2.3-1.1.3-2.6.7-4.4 1.2-3.7 1-8.9 2.4-14.6 4s-10.9 2.9-14.6 3.8c-1.9.5-3.4.8-4.5 1-.5.1-.9.2-1.2.2-.3.1-.4.1-.4.1s.1-.1.4-.1c.3-.1.7-.2 1.2-.3 1.1-.3 2.6-.7 4.4-1.2 3.7-1 8.9-2.4 14.6-4s10.9-2.9 14.6-3.8c1.9-.5 3.4-.8 4.5-1 .5-.1.9-.2 1.2-.2.3-.1.4-.1.4-.1z"
                    />
                    <path
                        class="st1"
                        d="M76 243.8s-5.9 2 .1 14.7c6.1 12.7 10.3 19 10.3 19s1.1 2.9-1.4 3.3-7.8-.6-9 2.3c-1.2 3.1 1 6.1 5.5 8.8 4.5 2.7 14.2 9 15 9.5.9.6 1.7 1.9.1 2.5-1.6.5-13.8 1.5-13 7.2s14.6 11.2 16.1 11.8c1.5.6 1.8 1.3 1.7 2.1-.1.8-4.3.8-7.7 1.2-3.4.4-7.4 1.5-6.6 4.8.7 3.3 8.8 10.3 28.8 12.8l9.3.6 5.3-7.8c10.3-17.3 9.7-28 7.6-30.6-2.1-2.6-5.4-.2-7.8 2.3-2.4 2.5-4.9 5.8-5.7 5.4-.7-.4-1-1.1-.6-2.6.4-1.6 4.6-15.8.6-19.9-4-4.2-12.3 4.8-13.7 5.8-1.4 1-2-.5-1.9-1.6.1-1 1.1-12.5 1.7-17.7s-.4-8.8-3.5-9.7c-3.1-.9-5.6 3.9-7.4 5.6s-3.5-.9-3.5-.9-2.4-7.2-8.6-19.8c-6.3-12.6-11.7-9-11.7-9.1"
                    />
                    <path
                        class="st0"
                        d="M125.5 346.6c-4.6-9.3-12.4-25.9-19.3-40.1-6.8-14.2-13-27.1-17.5-36.3-2.3-4.6-4.1-8.4-5.4-11-.6-1.3-1.1-2.3-1.5-3-.2-.3-.3-.6-.4-.8s-.1-.3-.1-.3.1.1.1.3l.4.8c.4.7.9 1.7 1.5 3 1.3 2.6 3.2 6.3 5.5 10.9 4.6 9.3 10.8 22.1 17.6 36.3 6.8 14.2 14.6 30.8 19.2 40.1"
                    />
                    <path
                        class="st0"
                        d="M83.5 285s.2.1.6.2 1 .4 1.7.7c1.4.6 3.4 1.4 5.6 2.4 2.1 1 4 1.8 5.5 2.5.7.3 1.2.5 1.7.7l.6.3s-.2-.1-.6-.2-1-.4-1.7-.7c-1.4-.6-3.4-1.5-5.6-2.4-2.1-.9-4.1-1.8-5.5-2.5-.7-.3-1.2-.5-1.7-.7l-.6-.3zm16.4 6.2c-.1 0 1.5-4.2 3.5-9.3 2-5.1 3.7-9.2 3.8-9.1.1 0-1.5 4.2-3.5 9.3-2.1 5-3.7 9.1-3.8 9.1zm9.5 22.3s.1-.2.4-.6.7-.9 1.1-1.5c1-1.3 2.3-3 3.7-5 1.4-2 2.6-3.8 3.5-5.1.4-.6.7-1.2 1-1.6.2-.4.4-.6.4-.6l-.3.6c-.2.4-.5.9-.9 1.6-.8 1.4-2 3.2-3.4 5.2s-2.8 3.7-3.8 4.9c-.5.6-.9 1.1-1.2 1.4-.3.5-.5.7-.5.7zm-16.1-2.4h.6c.5.1 1 .1 1.7.2 1.5.2 3.5.4 5.7.7 2.2.3 4.2.6 5.7.8.7.1 1.2.2 1.7.3.4.1.6.1.6.1h-.6c-.5 0-1-.1-1.7-.2-1.5-.2-3.5-.4-5.7-.7-2.2-.3-4.2-.6-5.7-.8-.7-.1-1.2-.2-1.7-.3-.4 0-.6-.1-.6-.1zm5.9 20.8h.8c.6.1 1.3.1 2.2.2 1.9.2 4.4.5 7.3.9 2.8.4 5.4.7 7.3.9.9.1 1.6.2 2.2.3.5.1.8.1.8.2h-.8c-.6-.1-1.3-.1-2.2-.2-1.9-.2-4.4-.5-7.3-.9-2.8-.4-5.4-.7-7.3-.9-.9-.1-1.6-.2-2.2-.3-.5-.2-.8-.2-.8-.2zm20.1 2.3s.2-.3.5-.7c.4-.5.8-1.1 1.4-1.9 1.2-1.6 2.8-3.9 4.5-6.4s3.2-4.9 4.3-6.6c.5-.8.9-1.5 1.3-2 .3-.5.5-.7.5-.7s-.1.3-.4.8c-.3.5-.7 1.2-1.2 2.1-1 1.7-2.5 4.1-4.2 6.7s-3.3 4.8-4.6 6.4c-.6.8-1.1 1.4-1.5 1.9-.4.2-.6.4-.6.4z"
                    />
                    <path
                        class="st19"
                        d="M73.7 311.8c-3.5-4.1-3.9-10.7-3.4-16 .5-5.4 1.8-10.7.9-16-.5-3.1-1.7-6.1-2.1-9.3-.4-3.2.2-6.7 2.6-8.8 2.8-2.3 7.2-1.8 10.2.4 2.9 2.2 4.6 5.7 5.9 9.1 2.7 7.6 3.7 16 1.5 23.7s-7.5 14.6-15.2 17m18 9.2c.6-2 1.8-3.9 3.7-4.7 2-.8 4.2-.4 6.3.4 2 .7 4 1.7 6.1 1.8 2.1.1 4.6-.9 5.2-2.9.6-1.9-.6-4-2-5.4-3.1-2.9-7.6-4.2-11.8-3.2-4.1 1-7.6 4.2-9 8.2"
                    />
                    <path
                        d="M92.1 321.1c.6-2 1.8-3.9 3.7-4.7 2-.8 4.2-.4 6.3.4 2 .7 4 1.7 6.1 1.8 2.1.1 4.6-.9 5.2-2.9.6-1.9-.6-4-2-5.4-3.1-2.9-7.6-4.2-11.8-3.2-4.1 1-7.6 4.2-9 8.2"
                    />
                    <path
                        class="st19"
                        d="M75.2 329.7c-3.1-3-3-8.2-1.4-12.2s5-7.1 8.8-9.2c7.4-4 16.7-4.3 24.3-.8-3.8.1-7.4 2.3-9.3 5.5-1.7 2.9-2.1 6.3-3.5 9.3-1.6 3.4-4.5 6.1-7.9 7.4-3.6 1.4-7.6 1.4-11 0"
                    />
                    <path
                        class="st21"
                        d="M72 345.4v-1.9c0-1.2.1-2.9.4-5s.7-4.6 1.3-7.3c.6-2.7 1.8-5.6 3.3-8.4 3.2-5.7 7.6-9.7 11.1-12 .9-.6 1.7-1.1 2.4-1.5.7-.4 1.4-.7 1.9-1 .5-.2.9-.4 1.3-.5.3-.1.4-.2.4-.2s-.1.1-.4.2c-.3.2-.7.3-1.2.6s-1.2.6-1.9 1-1.5.9-2.4 1.5c-3.5 2.3-7.8 6.4-11 12s-4.1 11.4-4.7 15.6c-.3 2.1-.4 3.8-.5 4.9 0 .6-.1 1-.1 1.4.1.5.1.6.1.6z"
                    />
                    <path
                        class="st19"
                        d="M41.8 300.4c-6.4 3.9-6.4 7.4-5.3 10.7 1.1 3.3 5 5.6 8.3 4.4 1.8-.7 3.2-2.3 4.3-3.9s2.2-3.3 3.8-4.5 3.9-1.6 5.5-.5"
                    />
                    <path
                        d="M41.8 300.4c-6.4 3.9-6.4 7.4-5.3 10.7 1.1 3.3 5 5.6 8.3 4.4 1.8-.7 3.2-2.3 4.3-3.9s2.2-3.3 3.8-4.5 3.9-1.6 5.5-.5"
                    />
                    <path
                        class="st19"
                        d="M37 304.7c1.7-2.3 5.8-3 8.5-1.8 2.6 1.2 4.5 3.5 6.3 5.8 1.7 2.3 3.4 4.7 5.8 6.3 2.4 1.6 5.7 2.2 8.1.6 1.6-1.1 2.5-2.9 2.7-4.8.3-1.9 0-3.8-.4-5.6-.6-2.7-1.5-5.5-3.7-7.2-2.4-1.9-5.7-2-8.8-1.9-3.5.1-7.1.4-10.4 1.6-3.3 1.1-6.7 3.7-8.1 7"
                    />
                    <path
                        class="st21"
                        d="M66.4 345.1v-.6c0-.4 0-.9-.1-1.6 0-1.4-.1-3.4-.2-5.9s-.2-5.4-.4-8.7c-.2-3.3-.4-6.9-.9-10.6-.3-1.9-.5-3.7-1.1-5.4-.5-1.7-1.2-3.3-2-4.7-1.5-2.9-3.4-5.2-5.2-6.9-1.8-1.7-3.6-2.7-4.8-3.3-.6-.3-1.1-.5-1.5-.6-.3-.1-.5-.2-.5-.2s.2 0 .5.2c.4.1.9.3 1.5.6 1.3.6 3.1 1.6 4.9 3.2 1.8 1.7 3.8 4 5.3 6.9.8 1.5 1.5 3 2 4.8.5 1.7.8 3.6 1.1 5.4.5 3.8.7 7.4.9 10.6.2 3.3.2 6.2.3 8.7 0 2.5.1 4.5.1 5.9v1.6c.2.4.2.6.1.6zm2.9 0s0-.1-.1-.2c0-.1-.1-.3-.2-.5-.2-.5-.3-1.2-.5-2.1-.3-1.9-.6-4.6-.5-8s.7-7.4 1.9-11.7c1.3-4.3 3.1-8.8 4.7-13.7 1.7-4.9 2.6-9.7 3-14.1s.4-8.4.3-11.8-.3-6.1-.4-8c-.1-.9-.1-1.6-.1-2.2v-.8.2c0 .1 0 .3.1.6 0 .5.1 1.2.2 2.2.2 1.9.4 4.6.5 8s.2 7.4-.2 11.8-1.3 9.3-3 14.2c-1.6 4.9-3.5 9.4-4.8 13.7-1.3 4.2-1.8 8.2-2 11.6s.1 6.1.4 7.9c.2.9.3 1.6.4 2.1.1.2.1.4.1.5.2.2.2.3.2.3z"
                    />
                </svg>
            </div>
        </x-tinoecom::empty-state>
    @else
        <div class="mt-10">
            {{ $this->table }}
        </div>
    @endif

    <x-tinoecom::learn-more :name="__('tinoecom::pages/discounts.menu')" link="discounts" />
</x-tinoecom::container>
