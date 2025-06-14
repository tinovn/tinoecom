<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Models\Role;

final class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Role::create([
            'name' => config('tinoecom.core.users.admin_role'),
            'display_name' => __('Administrator'),
            'description' => __('Site administrator with access to shop admin panel and developer tools.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => config('tinoecom.core.users.manager_role'),
            'display_name' => __('Manager'),
            'description' => __('Site manager with access to shop admin panel and publishing menus.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => config('tinoecom.core.users.default_role'),
            'display_name' => __('User'),
            'description' => __('Site customer role with access on front site.'),
            'can_be_removed' => false,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
