<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Contracts\Builder;

interface Authorizable
{
    public function isAuthorized(): bool;

    public function setAuthorized(bool $authorized = true): self;
}
