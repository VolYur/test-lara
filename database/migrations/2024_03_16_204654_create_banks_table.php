<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('description', 755);
            $table->string('logo', 255);
            $table->string('website', 255);
            $table->string('phone_number', 255);
            $table->string('email', 255);
            $table->string('address', 255);
            $table->decimal('rating', 2, 1);


            $table->unique('slug');
        });

        Schema::create('bank_branches', function (Blueprint $table) {
            $table->id();
            $table->string('bank_slug', 255);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string('phone_number', 255);
            $table->timestamps();

            $table->foreign('bank_slug')
                ->references('slug')
                ->on('banks');

            $table->index(['bank_slug', 'latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_branches');
        Schema::dropIfExists('banks');
    }
};
