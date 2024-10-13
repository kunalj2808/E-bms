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
        {
            Schema::create('consumers', function (Blueprint $table) {
                $table->id();
                $table->string('flat_number')->nullable(); // Flat number, can be nullable
                $table->string('meter_number')->unique();  // Meter number, must be unique
                $table->string('consumer_name');           // Consumer name, not null
                $table->text('mailing_address')->nullable(); // Mailing address, optional
                $table->text('supply_at')->nullable();     // Supply location, optional
                $table->timestamp('created_at')->useCurrent();  // Date stamp (created_at)
                $table->timestamp('updated_at')->useCurrent()->nullable();  // Date stamp (updated_at)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumers');
    }
};
