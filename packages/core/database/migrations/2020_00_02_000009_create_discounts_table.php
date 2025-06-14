<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tinoecom\Core\Helpers\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->getTableName('discounts'), function (Blueprint $table): void {
            $this->addCommonFields($table);

            $table->boolean('is_active')->default(false);
            $table->string('code')->unique()->index();
            $table->string('type');
            $table->integer('value');
            $table->string('apply_to');
            $table->string('min_required');
            $table->string('min_required_value')->nullable();
            $table->string('eligibility');
            $table->unsignedInteger('usage_limit')->nullable();
            $table->boolean('usage_limit_per_user')->default(false);
            $table->unsignedInteger('total_use')->default(0);
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
        });

        Schema::create($this->getTableName('discountables'), function (Blueprint $table): void {
            $this->addCommonFields($table);
            $table->string('condition')->nullable(); // apply_to, eligibility
            $table->unsignedInteger('total_use')->default(0);
            $table->morphs('discountable');

            $this->addForeignKey($table, 'discount_id', $this->getTableName('discounts'), false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTableName('discountables'));
        Schema::dropIfExists($this->getTableName('discounts'));
    }
};
