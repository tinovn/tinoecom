<?php

declare(strict_types=1);

namespace Tinoecom\Core\Repositories;

final class CollectionRepository extends Repository
{
    public function model(): string
    {
        return config('tinoecom.models.collection');
    }
}
