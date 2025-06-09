<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Spatie\Permission\Models\Role as Model;

/**
 * @property-read int $id
 * @property string $name
 * @property string $guard_name
 * @property bool $can_be_removed
 * @property string $display_name
 * @property string|null $description
 */
class Role extends Model
{
    protected $casts = [
        'can_be_removed' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->name === config('tinoecom.core.users.admin_role');
    }
}
