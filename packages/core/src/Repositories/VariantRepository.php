<?php

declare(strict_types=1);

namespace Tinoecom\Core\Repositories;

final class VariantRepository extends Repository
{
    public function model(): string
    {
        return config('tinoecom.models.variant');
    }
}
