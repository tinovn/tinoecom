<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Initialization;

use Tinoecom\Livewire\Components\Initialization\Steps\StoreAddress;
use Tinoecom\Livewire\Components\Initialization\Steps\StoreInformation;
use Tinoecom\Livewire\Components\Initialization\Steps\StoreSocialLink;
use Spatie\LivewireWizard\Components\WizardComponent;

final class InitializationWizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            StoreInformation::class,
            StoreAddress::class,
            StoreSocialLink::class,
        ];
    }
}
