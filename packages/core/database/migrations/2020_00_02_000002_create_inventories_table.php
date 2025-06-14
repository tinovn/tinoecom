<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Helpers\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->getTableName('inventories'), function (Blueprint $table): void {
            $this->addCommonFields($table);

            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->string('street_address');
            $table->string('street_address_plus')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->string('phone_number')->nullable();
            $table->integer('priority')->default(0);
            $table->decimal('latitude', 10, 5)->nullable();
            $table->decimal('longitude', 10, 5)->nullable();
            $table->boolean('is_default')->default(false);

            $this->addForeignKey($table, 'country_id', $this->getTableName('countries'));
        });

        Schema::create($this->getTableName('inventory_histories'), function (Blueprint $table): void {
            $this->addCommonFields($table);

            $table->morphs('stockable');
            $table->nullableMorphs('reference');
            $table->integer('quantity');
            $table->integer('old_quantity')->default(0);
            $table->string('event', 75)->nullable();
            $table->text('description')->nullable();

            $this->addForeignKey($table, 'inventory_id', $this->getTableName('inventories'), false);
            $this->addForeignKey($table, 'user_id', 'users', false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTableName('inventory_histories'));
        Schema::dropIfExists($this->getTableName('inventories'));
    }
};
