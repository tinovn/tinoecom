<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Models\Country;

final class CountriesTableSeeder extends Seeder
{
    protected array $countries;

    public function __construct()
    {
        $this->countries = include __DIR__ . '/../data/countries.php';
    }

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $countries = collect($this->countries)
            ->map(fn ($country): array => [
                'name' => $country['name']['common'],
                'name_official' => $country['name']['official'],
                'region' => $country['region'],
                'subregion' => $country['subregion'],
                'cca2' => $country['cca2'],
                'cca3' => $country['cca3'],
                'flag' => $country['flag'],
                'latitude' => $country['latlng'][0],
                'longitude' => $country['latlng'][1],
                'phone_calling_code' => json_encode($country['idd']),
                'currencies' => json_encode($country['currencies']),
            ])
            ->toArray();

        Country::query()->insert($countries);

        Schema::enableForeignKeyConstraints();
    }
}
