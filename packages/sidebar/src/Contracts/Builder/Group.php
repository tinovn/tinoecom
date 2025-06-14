<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Contracts\Builder;

use Illuminate\Support\Collection;

interface Group extends Authorizable, Itemable
{
    public function getName(): string;

    public function setName(string $name): self;

    public function weight(int $weight): self;

    public function getWeight(): int;

    public function hideHeading(bool $hide = true): self;

    public function shouldShowHeading(): bool;

    public function getClass(): ?string;

    public function setClass(string $class): self;

    public function getHeadingClass(): ?string;

    public function setHeadingClass(string $class): self;

    public function getGroupItemsClass(): ?string;

    public function setGroupItemsClass(string $class): self;

    public function getItems(): Collection;
}
