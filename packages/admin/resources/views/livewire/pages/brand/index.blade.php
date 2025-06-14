@php
    $total = $this->table->getRecords()->total();
@endphp

<x-tinoecom::container class="py-5">
    <x-tinoecom::heading :title="__('tinoecom::pages/brands.menu')">
        <x-slot name="action">
            @if ($total > 0)
                @can('add_brands')
                    <x-tinoecom::buttons.primary
                        wire:click="$dispatch('openPanel', { component: 'tinoecom-slide-overs.brand-form' })"
                        type="button"
                    >
                        {{ __('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/brands.single')]) }}
                    </x-tinoecom::buttons.primary>
                @endcan
            @endif
        </x-slot>
    </x-tinoecom::heading>

    @if ($total === 0)
        <x-tinoecom::empty-state
            :title="__('tinoecom::pages/brands.title')"
            :content="__('tinoecom::pages/brands.content')"
            :button="__('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/brands.single')])"
            panel="{ component: 'tinoecom-slide-overs.brand-form' }"
            permission="add_brands"
        >
            <div class="shrink-0">
                <svg
                    class="h-64 w-auto lg:h-auto"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 356 285"
                >
                    <style>
                        .st9 {
                            opacity: 0.5;
                            fill: #fff;
                        }
                        .st10 {
                            fill: #ac94fa;
                        }
                        .st11,
                        .st13 {
                            fill: none;
                            stroke: #101c59;
                            stroke-width: 0.75;
                            stroke-miterlimit: 10;
                        }
                        .st13 {
                            stroke: #52a1bf;
                            stroke-width: 0.5;
                        }
                        .st14 {
                            fill: #3f83f8;
                        }
                        .st16 {
                            fill: #5521b5;
                        }
                        .st17 {
                            fill: none;
                            stroke: #1b203f;
                            stroke-width: 0.75;
                            stroke-miterlimit: 10;
                        }
                        .st19 {
                            fill: #6875f5;
                        }
                        .st20,
                        .st22 {
                            fill: none;
                            stroke: #fff;
                            stroke-width: 0.5;
                            stroke-miterlimit: 10;
                        }
                        .st22 {
                            stroke: #09005f;
                        }
                    </style>
                    <path
                        d="M322.9 133.1c2.7 12.9 3.3 26.3 1 39.8-5.5 31.9-24 61.7-50.2 80.7-40.4 29.4-95.6 34.2-143.2 18.9-22.2-7.2-45.2-22.7-57.7-42.9C60 209 47.3 185.1 44.9 160.5c-7-70.9 50-139.4 119.6-149 27.9-3.9 63.7 3.2 87.7 18.1 19.5 12.1 35.3 29.6 47.6 49 10.5 16.9 19.1 35.3 23.1 54.5z"
                        fill="#e1effe"
                    />
                    <path
                        fill="#101c59"
                        d="M149.1 252h68.4c7.4 0 12.5-5.8 11.4-13L202.3 64.2c-1.1-7.2-8-13-15.3-13h-68.4c-7.4 0-12.5 5.8-11.4 13L133.8 239c1.1 7.2 8 13 15.3 13z"
                    />
                    <path
                        fill="#fff"
                        d="M149.7 246.8h73.1c4.3 0 7.2-3.4 6.6-7.5L201.9 59.5c-.6-4.2-4.6-7.5-8.9-7.5h-73c-4.3 0-7.2 3.4-6.6 7.5l27.4 179.8c.7 4.2 4.7 7.5 8.9 7.5z"
                    />
                    <path
                        fill="#000455"
                        d="M151.4 59.5h12.4c.5 0 .9-.4.8-.9-.1-.5-.6-.9-1.1-.9h-12.4c-.5 0-.9.4-.8.9.1.5.6.9 1.1.9zM171.3 59.4c.5 0 .9-.4.8-.9-.1-.5-.6-.9-1.1-.9-.5 0-.9.4-.8.9.1.5.6.9 1.1.9z"
                    />
                    <path
                        fill="#458aa3"
                        d="M120.3 135.7c1 0 1.7-.8 1.5-1.8l-1.1-7.1c-.1-1-1.1-1.8-2.1-1.8s-1.7.8-1.5 1.8l1.1 7.1c.2 1 1.1 1.8 2.1 1.8zM115.2 102.2c1 0 1.7-.8 1.5-1.8l-3.3-21.6c-.1-1-1.1-1.8-2.1-1.8s-1.7.8-1.5 1.8l3.3 21.6c.1 1 1.1 1.8 2.1 1.8z"
                    />
                    <path
                        fill="#101c59"
                        d="M114.2 102.2c1 0 1.7-.8 1.5-1.8l-3.3-21.6c-.1-1-1.1-1.8-2.1-1.8s-1.7.8-1.5 1.8l3.3 21.6c.2 1 1.1 1.8 2.1 1.8zM119.3 135.7c1 0 1.7-.8 1.5-1.8l-1.1-7.1c-.1-1-1.1-1.8-2.1-1.8s-1.7.8-1.5 1.8l1.1 7.1c.2 1 1.1 1.8 2.1 1.8z"
                    />
                    <path
                        d="M122.2 148.3c1 0 1.7-.8 1.5-1.8l-1.1-7.1c-.1-1-1.1-1.8-2.1-1.8s-1.7.8-1.5 1.8l1.1 7.1c.2 1 1.1 1.8 2.1 1.8z"
                        fill="#aeb3bd"
                    />
                    <path
                        fill="#101c59"
                        d="M121.2 148.3c1 0 1.7-.8 1.5-1.8l-1.1-7.1c-.1-1-1.1-1.8-2.1-1.8s-1.7.8-1.5 1.8l1.1 7.1c.2 1 1.1 1.8 2.1 1.8z"
                    />
                    <path fill="#a4cafe" d="M140.5 236l88.5-.1-26.2-171.6-88.5.1z" />
                    <path
                        fill="#1a56db"
                        d="M147.7 211.8l35.3-1.6-5-32.9-35.3 1.6zM163.5 170.7l34.9-.1-4.5-33.7-35.4.9zM205 222.4l19.4-.5-5-32.8-19.5.4z"
                    />
                    <path fill="#1a56db" d="M135.1 130.2l45.3-.8-9-58.9-45.3.7z" />
                    <path class="st9" d="M184.7 180.1l45.4-.7-9-59-45.4.8z" />
                    <path
                        fill="#458aa3"
                        d="M139.7 238.2L112.6 60.6c-.8-5.3 3-9.6 8.4-9.6h70.9c5.4 0 10.5 4.3 11.3 9.6l27.1 177.7c.8 5.3-3 9.6-8.4 9.6H151c-5.5 0-10.5-4.3-11.3-9.7zM121.3 53c-4.3 0-7.2 3.4-6.6 7.6l27.1 177.7c.6 4.2 4.6 7.6 8.9 7.6h70.9c4.3 0 7.2-3.4 6.6-7.6L201.1 60.5c-.6-4.2-4.6-7.6-8.9-7.6l-70.9.1z"
                    />
                    <path
                        fill="#000455"
                        d="M141 238.8L113.8 60.3c-.7-4.5 2.5-8.2 7.1-8.2h71.2c4.6 0 9 3.7 9.6 8.2L229 238.7c.7 4.5-2.5 8.2-7.1 8.2h-71.2c-4.6.1-9-3.6-9.7-8.1zM121.1 52.9c-4.2 0-7.1 3.3-6.5 7.4l27.2 178.4c.6 4.1 4.5 7.4 8.7 7.4h71.2c4.2 0 7.1-3.3 6.5-7.4L201 60.3c-.6-4.1-4.5-7.4-8.7-7.4h-71.2z"
                    />
                    <path
                        class="st9"
                        d="M154.5 228.8h60.2c2.9 0 5-2.5 4.6-5.3-.4-2.5-2.6-4.4-5.1-4.4H154c-2.9 0-5 2.5-4.6 5.3.4 2.5 2.6 4.4 5.1 4.4z"
                    />
                    <ellipse
                        transform="rotate(-45.001 51.266 161.85)"
                        class="st10"
                        cx="51.3"
                        cy="161.8"
                        rx="21.2"
                        ry="21.2"
                    />
                    <ellipse
                        transform="rotate(-76.714 275.627 58.626)"
                        class="st10"
                        cx="275.6"
                        cy="58.6"
                        rx="19.2"
                        ry="19.2"
                    />
                    <circle class="st10" cx="289.7" cy="243.6" r="11" />
                    <path
                        class="st11"
                        d="M251.1 55.9c0 2.3-1.9 4.1-4.1 4.1-2.3 0-4.1-1.9-4.1-4.1 0-2.3 1.9-4.1 4.1-4.1 2.2 0 4.1 1.9 4.1 4.1zM64.2 169.3c0 4.8-3.9 8.6-8.6 8.6-4.8 0-8.6-3.9-8.6-8.6 0-4.8 3.9-8.6 8.6-8.6 4.7 0 8.6 3.9 8.6 8.6z"
                    />
                    <g>
                        <ellipse
                            transform="rotate(-56.675 182.772 200.554)"
                            fill="#fff"
                            cx="182.8"
                            cy="200.6"
                            rx="12.3"
                            ry="15.3"
                        />
                        <path
                            fill="#101c59"
                            d="M185.8 196.7c.4 1.9-1 3.5-3.1 3.4-2.1-.1-4.1-1.7-4.4-3.6-.4-1.9 1-3.5 3.1-3.4 2.1 0 4 1.7 4.4 3.6zM191.6 206.7c-1.5-3.2-5-5.7-8.8-5.8-3.7-.1-6.4 2.2-6.7 5.4l15.5.4z"
                        />
                    </g>
                    <g>
                        <path
                            fill="#101c59"
                            d="M155.7 17.3v.2c-.2 1-1.1 1.6-2.1 1.5l-31.1-5.3c-1-.2-1.6-1.1-1.5-2.1v-.2c.2-1 1.1-1.6 2.1-1.5l31.1 5.3c1 .2 1.7 1.1 1.5 2.1z"
                        />
                        <defs>
                            <path
                                id="SVGID_1_"
                                d="M145.6 18l.7-4.4c.2-1.4 1.6-2.4 3.1-2.2l2.6.4-1.6 9.7-2.6-.4c-1.5-.3-2.5-1.6-2.2-3.1z"
                            />
                        </defs>
                        <clipPath id="SVGID_2_">
                            <use xlink:href="#SVGID_1_" overflow="visible" />
                        </clipPath>
                        <g clip-path="url(#SVGID_2_)">
                            <path
                                transform="rotate(99.248 148.557 16.236)"
                                fill="#101c59"
                                d="M144.6 13.6h7.9v5.3h-7.9z"
                            />
                            <path class="st13" d="M152.4 14.5l-6.9-1.2M152 16.8l-6.9-1.1M151.6 19.2l-6.9-1.1" />
                        </g>
                        <path
                            fill="#101c59"
                            d="M174.8 28.1c-5.4 6.1-14.7 6.6-20.8 1.2-6.1-5.4-6.6-14.7-1.2-20.8 5.4-6.1 14.7-6.6 20.8-1.2 6 5.4 6.5 14.7 1.2 20.8z"
                        />
                        <ellipse
                            transform="matrix(.02733 -.9996 .9996 .02733 140.98 181.498)"
                            class="st14"
                            cx="163.8"
                            cy="18.3"
                            rx="11.9"
                            ry="11.9"
                        />
                        <path
                            d="M157.9 24.9c-3.6-3.2-4-8.8-.7-12.4"
                            fill="none"
                            stroke="#101c59"
                            stroke-width=".5"
                            stroke-miterlimit="10"
                        />
                    </g>
                    <path
                        class="st11"
                        d="M254.8 248.9c0 3-2.4 5.4-5.4 5.4s-5.4-2.4-5.4-5.4c0-3 2.4-5.4 5.4-5.4s5.4 2.4 5.4 5.4z"
                    />
                    <g>
                        <path fill="#101c59" d="M112.9 150.1l-52.2-30.7L69.8 93l8.2.1 55.4 31.1-15 25z" />
                        <path class="st16" d="M112.9 150.1L56 117l13.8-24 56.7 32.6z" />
                        <path
                            class="st17"
                            d="M66.2 99.2l56.9 32.7M79 125c1.3-2 4-3.2 6.3-2.5 2.3.7 3.7 3.8 2.3 5.8 2-1.2 4.7-2.3 6.6-.9 1.7 1.3 1.5 3.9 1.1 6 1.2-1.8 3.9-2.4 5.8-1.4s2.9 3.6 2.1 5.6"
                        />
                    </g>
                    <g>
                        <path
                            class="st16"
                            d="M317.8 89.1c-1.6-1.2-3.3-2.3-5.1-3.2-2.5-1.2-5.4-1.9-8.2-1.5-1.9.3-3.6 1.2-5.3 2-1.7.8-3.3 1.9-5.2 2.1-2.9.3-5.2-1-7.7-2.2-.6-.3-1.3-.6-2-.5-.8.1-1.4.7-1.9 1.3-2.4 2.4-6.1 2.4-8.7 0-2.6-2.3-2.8-6.3-.4-8.9.3-.3.6-.6 1-.9-4.2-3.7-7-5.6-13-3.8-3.9 1.2-7.8 3.2-11.8 2.6-1.4-.2-2.8-.7-4.3-.7-2.3 0-4.3 1.2-6.2 2.4-2.6 1.6-5.2 3.3-7.8 4.9 0 .1.1.1.1.2 1.6 2.7 3.8 5.1 5.7 7.6.5-.4 1-.9 1.5-1.2 1.7-1 3.4-2.1 5.1-3.1.7-.4 1.4-.8 2.1-1 1.1-.2 2.3.1 3.4.3 1.8.3 3.8-.6 5.4-.3-.5 1.5-2.4 3.4-3.5 4.7-1.8 1.9-3.6 3.9-5.4 5.8-2.7 2.9-5.4 5.9-8 8.9l22 20c-.3-.3 8.9-9.9 9.5-10.6 2.4-2.6 4.9-5.1 7.4-7.5 1.4-1.3 2.7-2.8 4.3-4 1.3-1 3.1-2.7 4.7-3.1.3-.1.6-.1 1-.1.8 0 1.7.1 2.4.4.8.3 1.5.6 2.3.9 1.6.5 3.3.3 4.9-.2 3.3-1.1 4.8-3.8 7.9-5.1 2.1-1.3 5.1.4 7.4 1.5 2.1-2.3 4.3-4.9 6.4-7.7z"
                        />
                        <path
                            d="M254.4 85.5c2.2-1.4 4.7-2.2 6.9-3.7"
                            fill="none"
                            stroke="#292929"
                            stroke-width=".5"
                            stroke-linecap="round"
                            stroke-miterlimit="10"
                        />
                    </g>
                    <g>
                        <path
                            fill="#101c59"
                            d="M280.2 188.5c-.3-.4-.6-.9-.9-1.4-.8-1.4-1.1-3-1.3-4.6-.6-3.9-1.3-7.8-1.6-11.7-.6-6.6-.6-14-5.4-18.7-.7-.7-1.5-1.3-2.4-1.4-6.6-1.2-15.2 16-18.5 20.2l2.8 2.6c.5-.4.9-1 1.4-1.5 2.2-2.7 4.8-5.1 7.8-7 2.2 3.2 1.4 7.6 1.3 11.3-.1 1.8-.3 4.2.3 5.9 1.1 3.5 4.4 5.8 7.1 8.1 2.6 2.3 5.2 4.6 7.9 6.8 2.1 1.8 4.5 3.8 7.3 4.5.5.1 1 .2 1.4-.1.4-.2.6-.8.6-1.3s-.2-1-.4-1.4c-2-4.4-4.9-6.7-7.4-10.3z"
                        />
                        <path class="st17" d="M275 178.4c1.5 0 3-.3 4.5-.8M275.5 181.5c1.6-.3 3.2-.7 4.7-1" />
                        <path
                            d="M253.4 171.2c-.1-.1-.1-.2-.2-.3l-.3-.3c-.5-.5-1.1-.9-1.6-1.3-.4.6-.8 1.2-1.1 1.6l2.8 2.6c.5-.4.9-.9 1.3-1.4-.4-.3-.7-.6-.9-.9z"
                        />
                        <g>
                            <path
                                class="st14"
                                d="M270.7 206.2c-.1-.5-.3-1.1-.4-1.6-.3-1.6 0-3.2.3-4.8.8-3.9 1.5-7.7 2.6-11.5 1.8-6.4 4.3-13.4 1.5-19.4-.4-.9-.9-1.7-1.8-2.2-5.1-3-16.6 6.8-22.4 11.1.6 1.3 1.1 2.5 1.5 3.8 3-1.8 6.2-3.1 9.6-3.8 1 3.8-1.3 7.7-2.6 11-.7 1.7-1.7 3.8-1.8 5.7-.1 3.6 2.1 7 3.8 10.1 1.7 3 3.3 6.1 5 9.1 1.4 2.4 2.9 5.1 5.3 6.7.4.3.9.5 1.3.4.5-.1.9-.5 1-1 .2-.5.2-1 .1-1.5 0-4.6-1.9-7.8-3-12.1z"
                            />
                            <path class="st17" d="M268.9 196c1.4.2 2.8.7 3.9 1.6M268.4 198.9c1.1.3 2.3.7 3.4 1" />
                            <path
                                d="M252 176.9l-2.4 1.5c.6 1.3 1 2.7 1.4 4 .9-.5 1.7-1.1 2.6-1.6-.5-1.3-1-2.6-1.6-3.9z"
                            />
                        </g>
                    </g>
                    <g>
                        <path
                            class="st19"
                            d="M199 100.6c5.7-8.4 10.2-16.7 15.7-25.1 3.5-5.3 6.2-11.1 8.2-17.1 1.2-3.5 1.3-7.7 1.9-11.4-2.8-2.1-5.7-4.2-8.5-6.2l-6.6-4.8c-1.7-1.3-3.9-2.5-5.3-4.1 0 .1-.1.2-.3.5-.6-.2-1.3 0-1.9.2-3.5 1.1-6.8 2.6-9.8 4.3-13.5 7.9-22.9 21.5-32.3 34-5.4 7.1-13.1 14.5-16.6 22.8-.8 1.9-1.2 4-.6 6 .3 1.3 1 2.4 1.9 3.4.8.9 1.7 1.7 2.8 2.2 2.7 1.3 5.9.7 8.5-.8 3.9-2.3 5.9-6.1 8.9-9.3 3.5-3.8 7.1-7.6 10.5-11.5 4.3-4.9 8.1-10.3 12.4-15.2 2.7-3 5.5-6.3 8.4-9.1.2-.2.5-.2.8-.1 1.1.8 3.3 1.5 2.7 2.6-1 2-2.7 4.6-3.8 6.3-2.4 3.6-4.9 7.2-7.2 10.9-6.2 10-13.2 19.7-18.8 29.9-1.6 2.9-2.9 6.4-1.6 9.4.9 2 2.8 3.5 4.9 4.2 7 2.4 11.8-2.1 15.2-7.4 3.3-5 7.2-9.7 10.5-14.6z"
                        />
                        <path
                            fill="#101c59"
                            d="M174 122.3c-1.9-.7-3.9-2-5.1-3.7-.1 0-.2-.1-.3-.1-.5-.1-.8.3-.7.7.1.7.8 1.5 1.3 2 .6.6 1.3 1.1 2 1.5 1.4.8 3.1 1.5 4.8 1.6.6.1 1.2-.5 1.3-1.1-1.2-.2-2.3-.5-3.3-.9zM148.2 104.3c-2.1-.9-4.1-2.1-5.4-4-.1 0-.1 0-.2.1-.3.2-.5.5-.3.8 0 .1.1.2.1.3 0 .4.3.8.5 1.2l.9 1.2c.7.7 1.5 1.3 2.3 1.7.8.5 1.7.8 2.6 1.1.4.1.9.2 1.3.3.7.1 1.6.3 2.1-.3.3-.3.4-.7.3-1-1.3-.4-2.8-.9-4.2-1.4z"
                        />
                        <path
                            class="st11"
                            d="M217.6 51.9c-.5 1.9.3 4 1.4 5.6 1.1 1.7 2.5 3.2 3.3 5M191.1 37.8c3.6 1.9 7.9 2.5 11.9 1.7M213.4 43.4c-.9.4-.7 1.7-.4 2.7.8 2.8.5 5.9-.9 8.5M209.5 40.8c-2.6 2.8.8 8.1-1.8 10.9"
                        />
                        <path
                            fill="#101c59"
                            d="M213.3 54.2c-.1-.3-.2-.5-.4-.7-.1-.1-.2-.2-.3-.2-.2-.1-.5-.2-.8-.2-.2 0-.4 0-.6.1-.2.1-.4.2-.5.3-.2.1-.3.3-.3.5-.1.2-.1.4-.1.6 0 .1 0 .3.1.4.1.3.2.5.4.7.1.1.2.2.3.2.2.1.5.2.8.2.2 0 .4 0 .6-.1.2-.1.4-.2.5-.3.2-.1.3-.3.3-.5.1-.2.1-.4.1-.6-.1-.2-.1-.3-.1-.4zM207.6 50.4c-1.7 0-1.7 2.7 0 2.7s1.7-2.7 0-2.7z"
                        />
                    </g>
                    <g>
                        <path
                            class="st19"
                            d="M207 167.4c4.7 1.6 9.3 3.5 14 4.8 1 .3 2 .5 3 .3.5-.1 1-.4 1.3-.7.4-.5.4-1.2.5-1.9.2-3.1 1.2-6 2.9-8.6.6-.9 1.2-1.7 1.5-2.6.3-.8.7-2.5-.6-2.9l-5.6-1.9c-4.2-1.4-8.5-2.8-12.8-4.3-1.6-.6-2.9 0-4.5.1-1.9.1-3.6.7-5.4 1-2 .4-3.9.7-6 .9-4 .4-8 .3-12-.3-.6-.1-1.3-.2-1.9-.1-3 .5-2.7 4.2-1.2 6 .6.7 1.3 1.8 2.2 2.4.8.5 2.1.8 3 1.2 2.3.9 4.7 1.6 7 2.4 5 1.4 9.9 2.6 14.6 4.2z"
                        />
                        <path
                            fill="#101c59"
                            d="M180 158.3c.4.5.9.9 1.5 1.3 1 .6 2 1 3.1 1.4 3.6 1.4 7.1 2.8 10.8 3.8 3.7.9 7.3 2 10.8 3.4 3.8 1.5 7.4 3.4 11.2 5 1.8.7 3.7 1.4 5.6 1.9.8.2 1.7.6 2.5.6 1.1-.1 1.1-1.3.9-2.2-.2-1.2-.5-2.4-.7-3.5 0-.2-.1-.3-.2-.5s-.4-.3-.6-.3c-3.9-1.3-7.9-1.8-11.9-2.7-3.4-.8-6.7-1.7-10-2.7l-13.2-3.9c-2-.6-3.9-1.2-5.8-2-1.3-.6-2.6-1.2-3.8-2-.7-.5-1.5-1.8-1-2.7-.8 1.6-.5 3.6.8 5.1zM209 149.9c-.4 1.2 4.1 3.8 10 5.8s11.1 2.6 11.5 1.5c.4-1.2-4.1-3.8-10-5.8-6-2.1-11.1-2.7-11.5-1.5z"
                        />
                        <path
                            class="st19"
                            d="M211 149.8c.3-.5.5-1 .4-1.5-.2-1-1.4-1.7-2.5-1.7s-2.1.5-3 1c-2.6 1.4-5.3 2.9-8.2 3.6-.6.1-1.3.3-1.8.7-.5.4-.7 1.2-.2 1.7.2.2.5.1.7.3.9.7 2.1 1 3.3 1 2.6 0 4.4-1.1 6.6-1.9 1.8-.8 3.6-1.3 4.7-3.2z"
                        />
                        <path class="st20" d="M190.5 153.9c4.7 1.3 9.8 1.1 14.1-.8" />
                        <path
                            d="M192.4 155c-.3-1.4-.9-2.8-1.6-4.1-.3-.4-1-.1-.7.3.7 1.2 1.2 2.6 1.5 3.9.1.6 1 .4.8-.1zM195.1 155.4c-.3-1.6-.9-3.2-1.6-4.7-.2-.5-1-.1-.7.3.7 1.5 1.3 3 1.6 4.6 0 .5.8.3.7-.2zM198.3 155.7c-.4-1.8-1-3.5-2-5.2-.3-.5-1-.1-.7.3.9 1.6 1.5 3.3 1.9 5 .1.6.9.4.8-.1zM201.2 155c-.4-1.8-1-3.5-1.9-5.1-.2-.5-1-.1-.7.3.8 1.5 1.4 3.2 1.8 4.9.1.5.9.4.8-.1z"
                        />
                        <path d="M207.8 152.1c.9-.3 1.7-.6 2.5-1" fill="#ff4a4a" />
                        <path
                            class="st20"
                            d="M206.6 162.2c.7-1.2 1.7-2.2 2.8-2.9.5-.3 1.2-.6 1.7-.3.3.2.5.5.7.8.5 1.3.1 2.7-.4 3.9.6-1.3 1.3-2.7 2.7-3.3.2-.1.5-.2.7-.1.7.1 1 .8 1.1 1.5.1 1-.2 2-.7 2.8.4-.7.9-1.3 1.4-1.9.7-.7 1.8-1.3 2.7-.8.6.4.9 1.1.9 1.8 0 .8-.2 1.6-.7 2.2M185.6 151.2c.5.7.6 1.6.6 2.4 0 .8-.2 1.6-.4 2.5"
                        />
                    </g>
                    <g>
                        <ellipse
                            transform="rotate(-45.001 123.354 188.408)"
                            class="st22"
                            cx="123.4"
                            cy="188.4"
                            rx="18.2"
                            ry="18.2"
                        />
                        <ellipse
                            transform="rotate(-80.781 120.757 188.404)"
                            class="st22"
                            cx="120.8"
                            cy="188.4"
                            rx="18.2"
                            ry="18.2"
                        />
                        <path fill="#101c59" d="M162.4 258.7H99.9l5.2-72.9H152z" />
                        <path class="st19" d="M152 258.7H89.5l5.2-72.9h52.1z" />
                        <g>
                            <circle class="st22" cx="89" cy="204.1" r="15.7" />
                            <ellipse
                                transform="rotate(-56.055 86.77 204.49)"
                                class="st22"
                                cx="86.8"
                                cy="204.5"
                                rx="15.7"
                                ry="15.7"
                            />
                            <path fill="#101c59" d="M133.5 257l-8.8 1.7-43.9 8.6-7.7-62.4 39.6-7.8z" />
                            <path fill="#1a56db" d="M124.7 258.7L72 269l-7.6-62.4 43.9-8.6z" />
                        </g>
                        <g>
                            <ellipse
                                transform="rotate(-48.463 80.53 34.093)"
                                class="st22"
                                cx="80.5"
                                cy="34.1"
                                rx="12.3"
                                ry="13.4"
                            />
                            <path
                                class="st22"
                                d="M87.5 26.2c5.5 4.9 6.4 13 1.9 18.1-4.5 5.1-12.6 5.2-18.2.3-5.5-4.9-6.4-13-1.9-18.1 4.5-5 12.7-5.2 18.2-.3z"
                            />
                            <path fill="#101c59" d="M139 46l-7 7.9-23.2 26.2L71 42l23.3-26.3z" />
                            <path class="st16" d="M132 53.9l-26.3 29.7c-.8 1-2.3 1-3.2.1L66.3 47.2 89.6 21 132 53.9z" />
                        </g>
                        <circle fill="#fff" cx="91.1" cy="227" r="7.9" />
                    </g>
                    <path
                        class="st11"
                        d="M195.5 139c7.4-14.2 22.4-24.2 38.3-25.6M230.9 198.3c-10.6-.1-21.1 6.2-25.9 15.7M175.9 180.2c-1.9-10.9-8.8-20.7-18.3-26.3M95.9 175.8c.6-15.2-7.3-30.5-20.1-38.6M125.7 67.7c5.4 3.6 9.1 9.5 10 15.9"
                    />
                </svg>
            </div>
        </x-tinoecom::empty-state>
    @else
        <div class="mt-10">
            {{ $this->table }}
        </div>
    @endif

    <x-tinoecom::learn-more :name="__('tinoecom::pages/brands.menu')" link="brands" />
</x-tinoecom::container>
