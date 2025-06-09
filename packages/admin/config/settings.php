<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Setting Menu
    |--------------------------------------------------------------------------
    |
    | The menu for the generation of the settings page.
    | UntitledUI is the icon used. See https://blade-ui-kit.com/blade-icons?set=74
    |
    | 'icon' => 'name_of_the_set_icon'
    |
    */

    'items' => [
        [
            'name' => 'tinoecom::pages/settings/menu.general',
            'description' => 'tinoecom::pages/settings/menu.general_description',
            'icon' => 'untitledui-sliders',
            'route' => 'tinoecom.settings.shop',
            'permission' => null,
        ],
        [
            'name' => 'tinoecom::pages/settings/menu.staff',
            'description' => 'tinoecom::pages/settings/menu.staff_description',
            'icon' => 'untitledui-shield-separator',
            'route' => 'tinoecom.settings.users',
            'permission' => null,
        ],
        [
            'name' => 'tinoecom::pages/settings/menu.location',
            'description' => 'tinoecom::pages/settings/menu.location_description',
            'icon' => 'untitledui-marker-pin-flag',
            'route' => 'tinoecom.settings.locations',
            'permission' => null,
        ],
        [
            'name' => 'tinoecom::pages/settings/menu.payment',
            'description' => 'tinoecom::pages/settings/menu.payment_description',
            'icon' => 'untitledui-coins-hand',
            'route' => 'tinoecom.settings.payments',
            'permission' => null,
        ],
        [
            'name' => 'tinoecom::pages/settings/menu.legal',
            'description' => 'tinoecom::pages/settings/menu.legal_description',
            'icon' => 'untitledui-file-lock-02',
            'route' => 'tinoecom.settings.legal',
            'permission' => null,
        ],
        [
            'name' => 'tinoecom::pages/settings/menu.zone',
            'description' => 'tinoecom::pages/settings/menu.zone_description',
            'icon' => 'untitledui-globe-05',
            'route' => 'tinoecom.settings.zones',
            'permission' => null,
        ],
    ],

];
