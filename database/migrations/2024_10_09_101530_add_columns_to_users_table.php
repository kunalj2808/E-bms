<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_banner')->nullable();
            $table->string('designation')->default('admin');
            $table->string('admin_image')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('display_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name', 
                'admin_name', 
                'company_address', 
                'company_banner', 
                'designation', 
                'admin_image', 
                'phone_number', 
                'display_name'
            ]);
        });
    }
}
