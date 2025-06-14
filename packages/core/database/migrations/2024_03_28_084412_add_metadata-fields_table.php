<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Helpers\Migration;

return new class extends Migration
{
    protected array $tables = [
        'brands',
        'channels',
        'categories',
        'carriers',
        'collections',
        'discounts',
        'orders',
        'order_refunds',
        'products',
        'payment_methods',
        'user_addresses',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($this->getTableName($table), function (Blueprint $blueprint): void {
                $blueprint->json('metadata')->nullable();
            });
        }
    }
};
