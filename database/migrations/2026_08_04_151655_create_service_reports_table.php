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
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_no')->unique();
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('department');
            $table->string('equipment_brand');
            $table->string('equipment_model');
            $table->string('service_status');
            $table->text('problem');
            $table->text('action');
            $table->text('remark')->nullable();
            $table->text('recommendation')->nullable();
            $table->date('working_start');
            $table->date('working_finish');
            $table->string('working_status');
            $table->string('engineer_name');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};
