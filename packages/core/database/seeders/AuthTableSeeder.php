<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Database\Seeders\Auth\PermissionRoleTableSeeder;
use Tinoecom\Core\Database\Seeders\Auth\PermissionsTableSeeder;
use Tinoecom\Core\Database\Seeders\Auth\RolesTableSeeder;

final class AuthTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        app()['cache']->forget('spatie.permission.cache');

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
