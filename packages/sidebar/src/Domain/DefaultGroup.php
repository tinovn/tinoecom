<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Domain;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Serializable;
use Tinoecom\Sidebar\Contracts\Builder\Group;
use Tinoecom\Sidebar\Traits\AuthorizableTrait;
use Tinoecom\Sidebar\Traits\CacheableTrait;
use Tinoecom\Sidebar\Traits\CallableTrait;
use Tinoecom\Sidebar\Traits\ItemableTrait;

class DefaultGroup implements Group, Serializable
{
    use AuthorizableTrait;
    use CacheableTrait;
    use CallableTrait;
    use ItemableTrait;

    protected ?string $name = null;

    protected int $weight = 0;

    protected bool $heading = true;

    protected ?string $class = null;

    protected ?string $itemClass = null;

    protected ?string $headingClass = null;

    protected array $cacheables = [
        'name',
        'items',
        'weight',
        'heading',
    ];

    public function __construct(protected Container $container)
    {
        $this->items = new Collection;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Group
    {
        $this->name = $name;

        return $this;
    }

    public function weight(int $weight): Group
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function hideHeading(bool $hide = true): Group
    {
        $this->heading = ! $hide;

        return $this;
    }

    public function shouldShowHeading(): bool
    {
        return $this->heading;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): Group
    {
        $this->class = $class;

        return $this;
    }

    public function getGroupItemsClass(): ?string
    {
        return $this->itemClass;
    }

    public function setGroupItemsClass(string $class): Group
    {
        $this->itemClass = $class;

        return $this;
    }

    public function getHeadingClass(): ?string
    {
        return $this->headingClass;
    }

    public function setHeadingClass(string $class): Group
    {
        $this->headingClass = $class;

        return $this;
    }

    public function __serialize(): array
    {
        return [
            'name' => $this->name,
            'items' => $this->items,
            'weight' => $this->weight,
            'heading' => $this->heading,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->name = $data['name'];
        $this->items = $data['items'];
        $this->weight = $data['weight'];
        $this->heading = $data['heading'];
    }
}
