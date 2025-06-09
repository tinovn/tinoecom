<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

final class TinoecomSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $this->call(AuthTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(LegalsPageTableSeeder::class);
        $this->call(ChannelSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(PaymentMethodSeeder::class);

        Model::reguard();
    }
}
