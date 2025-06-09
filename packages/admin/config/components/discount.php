<?php

declare(strict_types=1);

use Tinoecom\Livewire;

return [

    /*
    |--------------------------------------------------------------------------
    | Livewire Pages
    |--------------------------------------------------------------------------
    */

    'pages' => [
        'discount-index' => Livewire\Pages\Discount\Index::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire Components
    |--------------------------------------------------------------------------
    */

    'components' => [
        'slide-overs.discount-form' => Livewire\SlideOvers\DiscountForm::class,
    ],

];
