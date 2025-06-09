<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Helpers\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName('currencies'), function (Blueprint $table): void {
            $table->string('code', 10)->unique()->change();
            $table->decimal('exchange_rate')->nullable()->change();
            $table->boolean('is_enabled')->default(true);
        });
    }
};
