<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            
            // Foreign key referencing the users table
            $table->foreignId('consumer_id')->constrained('consumers')->onDelete('cascade');
            
            // Reporting month (store only month and year)
            $table->string('reporting_month', 7); // Format 'YYYY-MM'
            
            // Bill date and due date
            $table->date('bill_date');
            $table->date('bill_due_date');
            
            // Other fields
            $table->text('remarks')->nullable();
            $table->decimal('current_reading', 8, 2)->nullable(false);
            $table->decimal('previous_reading', 8, 2)->nullable(false);
            $table->decimal('current_bill_amount', 10, 2)->nullable(false);
            $table->decimal('previous_due_amount', 10, 2)->nullable(false);
            $table->decimal('tariff_dg', 10, 2)->nullable(false);
            
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
        Schema::dropIfExists('bills');
    }
}
