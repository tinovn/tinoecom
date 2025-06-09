<?php

declare(strict_types=1);

use Tinoecom\Enum\FeatureState;

return [

    /*
    |--------------------------------------------------------------------------
    | Tinoecom Features
    |--------------------------------------------------------------------------
    |
    | If you want extends your tinoecom admin panel with custom components features,
    | Here you can specify custom Feature for each feature available on Tinoecom.
    |
    | Each feature has its own components, routes and views. Once you have disabled it,
    | its menu and all its views will no longer be accessible on the admin panel.
    |
    */

    'attribute' => FeatureState::Enabled,
    'brand' => FeatureState::Enabled,
    'category' => FeatureState::Enabled,
    'collection' => FeatureState::Enabled,
    'discount' => FeatureState::Enabled,
    'review' => FeatureState::Enabled,

];
