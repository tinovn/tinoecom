<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Models\Permission;
use Tinoecom\Core\Models\Role;

final class PermissionRoleTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $administrator = Role::query()
            ->where('name', config('tinoecom.core.users.admin_role'))
            ->firstOrFail();

        $permissions = Permission::all();

        $administrator->permissions()
            ->sync($permissions->pluck('id')->all());

        Schema::enableForeignKeyConstraints();
    }
}
