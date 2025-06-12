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
        Schema::table('uploaded_conversions', function (Blueprint $table) {
            $table->bigInteger('customer_id')->change();
            $table->bigInteger('conversion_action_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploaded_conversions', function (Blueprint $table) {
            $table->integer('customer_id')->change();
            $table->integer('conversion_action_id')->change();
        });
    }
};
