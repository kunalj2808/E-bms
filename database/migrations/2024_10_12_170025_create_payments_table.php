<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Foreign key referencing the bills table
            $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            
            // Payment-related fields
            $table->decimal('received_amount', 10, 2)->default(0)->nullable(false);
            $table->decimal('late_fees', 10, 2)->default(0)->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
