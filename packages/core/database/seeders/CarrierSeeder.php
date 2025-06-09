<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Tinoecom\Core\Models\Carrier;

final class CarrierSeeder extends Seeder
{
    public function run(): void
    {
        Carrier::query()->create([
            'name' => 'Manual',
            'slug' => 'manual',
            'is_enabled' => true,
        ]);
    }
}
