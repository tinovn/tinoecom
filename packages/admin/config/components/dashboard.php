<?php

declare(strict_types=1);

use Tinoecom\Livewire\Components;
use Tinoecom\Livewire\Pages;

return [

    /*
    |--------------------------------------------------------------------------
    | Livewire Pages
    |--------------------------------------------------------------------------
    */

    'pages' => [
        'dashboard' => Pages\Dashboard::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire Components
    |--------------------------------------------------------------------------
    */

    'components' => [
        // 'search' => Components\Search::class,
        'side-panel' => Components\SlideOverPanel::class,
        'modal' => Components\Modal::class,
    ],

];
