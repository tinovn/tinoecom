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
        'review-index' => Livewire\Pages\Reviews\Index::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire Components
    |--------------------------------------------------------------------------
    */

    'components' => [
        'slide-overs.review-detail' => Livewire\SlideOvers\ReviewDetail::class,
    ],

];
