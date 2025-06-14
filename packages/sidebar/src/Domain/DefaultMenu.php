<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Domain;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Serializable;
use Tinoecom\Sidebar\Contracts\Builder\Group;
use Tinoecom\Sidebar\Contracts\Builder\Menu;
use Tinoecom\Sidebar\Traits\AuthorizableTrait;
use Tinoecom\Sidebar\Traits\CacheableTrait;
use Tinoecom\Sidebar\Traits\CallableTrait;

class DefaultMenu implements Menu, Serializable
{
    use AuthorizableTrait;
    use CacheableTrait;
    use CallableTrait;

    /**
     * @var Collection|Group[]
     */
    protected Collection | array $groups;

    protected array $cacheables = [
        'groups',
    ];

    public function __construct(protected Container $container)
    {
        $this->groups = new Collection;
    }

    public function group(string $name, ?Closure $callback = null): Group
    {
        if ($this->groups->has($name)) {
            $group = $this->groups->get($name);
        } else {
            $group = $this->container->make(Group::class);
            $group->setName($name);
        }

        $this->call($callback, $group);

        $this->addGroup($group);

        return $group;
    }

    public function addGroup(Group $group): Menu
    {
        $this->groups->put($group->getName(), $group);

        return $this;
    }

    public function getGroups(): Collection
    {
        return $this->groups->sortBy(fn (Group $group) => $group->getWeight());
    }

    public function add(Menu $menu): Menu
    {
        /** @var Group $group */
        foreach ($menu->getGroups() as $group) {
            if ($this->groups->has($group->getName())) {
                /** @var Group $existingGroup */
                $existingGroup = $this->groups->get($group->getName());

                $group->hideHeading(! $group->shouldShowHeading());

                foreach ($group->getItems() as $item) {
                    $existingGroup->addItem($item);
                }
            } else {
                $this->addGroup($group);
            }
        }

        return $this;
    }

    public function __serialize(): array
    {
        return [
            'groups' => $this->groups,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->groups = $data['groups'];
    }
}
