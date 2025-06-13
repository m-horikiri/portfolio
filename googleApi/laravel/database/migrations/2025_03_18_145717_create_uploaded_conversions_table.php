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
        Schema::create('uploaded_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->boolean('validate_only')->nullable();
            $table->string('name')->nullable();
            $table->integer('costomer_id');
            $table->string('gclid');
            $table->integer('conversion_action_id');
            $table->string('conversion_date_time');
            $table->integer('conversion_value');
            $table->string('order_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_conversions');
    }
};
