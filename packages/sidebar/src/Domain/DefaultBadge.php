<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Domain;

use Illuminate\Container\Container;
use Serializable;
use Tinoecom\Sidebar\Contracts\Builder\Badge;
use Tinoecom\Sidebar\Traits\AuthorizableTrait;
use Tinoecom\Sidebar\Traits\CacheableTrait;

class DefaultBadge implements Badge, Serializable
{
    use AuthorizableTrait;
    use CacheableTrait;

    protected mixed $value = null;

    protected string $class = 'badge-sidebar';

    protected array $cacheables = [
        'value',
        'class',
    ];

    public function __construct(protected Container $container) {}

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function __serialize(): array
    {
        return [
            'value' => $this->value,
            'class' => $this->class,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->value = $data['value'];
        $this->class = $data['class'];
    }
}
