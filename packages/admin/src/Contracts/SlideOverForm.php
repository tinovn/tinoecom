<?php

declare(strict_types=1);

namespace Tinoecom\Contracts;

interface SlideOverForm
{
    public function getAction(): ?string;

    public function getTitle(): ?string;

    public function getDescription(): ?string;
}
