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
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->after('id');
            $table->dateTime('appointment_time')->after('service_id');
            $table->unsignedBigInteger('employee_id')->nullable()->after('appointment_time');

            // Add foreign keys if necessary
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['employee_id']);
            $table->dropColumn(['service_id', 'appointment_time', 'employee_id']);
        });
    }
};
