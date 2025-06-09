<?php

declare(strict_types=1);

namespace Tinoecom\Core\Repositories;

final class CategoryRepository extends Repository
{
    public function model(): string
    {
        return config('tinoecom.models.category');
    }
}
