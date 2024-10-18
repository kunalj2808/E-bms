<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bill_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('upto_50', 8, 2)->default(5)->nullable(false);
            $table->decimal('upto_50_150', 8, 2)->default(6)->nullable(false);
            $table->decimal('upto_150_300', 8, 2)->default(7)->nullable(false);
            $table->decimal('above_300', 8, 2)->default(8)->nullable(false);
            $table->decimal('tariff_dg', 8, 2)->default(10)->nullable(false);
            $table->decimal('service_tax_dg', 8, 2)->default(0)->nullable(false);
            $table->decimal('electricity_upto', 8, 2)->default(100)->nullable(false);
            $table->decimal('electicity_value', 8, 2)->default(6.5)->nullable(false);
            $table->decimal('electicity_above_value', 8, 2)->default(7)->nullable(false);
            $table->decimal('late_percentage', 8, 2)->default(1.25)->nullable(false);
            $table->decimal('maintain_cost', 8, 2)->default(1.25)->nullable(false);
            $table->string('qr_image')->nullable();
            $table->unsignedBigInteger('bill_id');
            
            // Foreign key constraint to bills table
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_settings');
    }
};
