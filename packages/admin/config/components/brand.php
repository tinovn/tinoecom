<?php

declare(strict_types=1);

use Tinoecom\Livewire;

return [

    /*
    |--------------------------------------------------------------------------
    | Livewire Pages
    |--------------------------------------------------------------------------
    |
    */

    'pages' => [
        'brand-index' => Livewire\Pages\Brand\Index::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire Components
    |--------------------------------------------------------------------------
    |
    */

    'components' => [
        'slide-overs.brand-form' => Livewire\SlideOvers\BrandForm::class,
    ],

];
