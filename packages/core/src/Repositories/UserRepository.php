<?php

declare(strict_types=1);

namespace Tinoecom\Core\Repositories;

use Tinoecom\Core\Models\User;

final class UserRepository extends Repository
{
    public function model(): string
    {
        return config('auth.providers.users.model', User::class);
    }
}
