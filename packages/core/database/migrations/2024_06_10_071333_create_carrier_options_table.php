<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Helpers\Migration;
use Tinoecom\Core\Models;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->getTableName('carrier_options'), function (Blueprint $table): void {
            $this->addCommonFields($table);

            $table->string('name')->unique();
            $table->string('description', 255)->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->integer('price');
            $table->foreignIdFor(Models\Carrier::class);
            $table->foreignIdFor(Models\Zone::class);
            $table->json('metadata')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTableName('carrier_options'));
    }
};
