<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Tinoecom\Core\Models\PaymentMethod;

final class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::query()->create([
            'title' => 'Cash',
            'slug' => 'cash',
            'is_enabled' => true,
        ]);
    }
}
