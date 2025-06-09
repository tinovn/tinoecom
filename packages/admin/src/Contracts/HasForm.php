<?php

declare(strict_types=1);

namespace Tinoecom\Contracts;

use Illuminate\Database\Eloquent\Model;

interface HasForm
{
    public function rules(): array;

    public function save(Model | string $model): mixed;
}
