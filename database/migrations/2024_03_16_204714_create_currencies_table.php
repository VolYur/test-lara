<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 90);
            $table->string('code', 4);
            $table->decimal('avg_bid', 10, 4);
            $table->decimal('avg_ask', 10, 4);
            $table->dateTime('actual_at');

            $table->unique('code');
        });

        Schema::create('currency_exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('bank_slug', 255);
            $table->string('code', 4);
            $table->decimal('bid', 10, 4);
            $table->decimal('ask', 10, 4);
            $table->dateTime('actual_at');

            $table->index(['bank_slug', 'code']);
            $table->index(['code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_exchange_rates');
        Schema::dropIfExists('currency');
    }
};
