<?php

declare(strict_types=1);

namespace Tinoecom\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

trait HasAuthenticated
{
    public function getUser(): Model | Authenticatable | null
    {
        return tinoecom()->auth()->user();
    }
}
