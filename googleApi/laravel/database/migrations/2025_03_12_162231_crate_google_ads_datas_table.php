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
        Schema::create('google_ads_datas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('media')->nullable();
            $table->string('gclid')->nullable();
            $table->string('acceptanceTime')->nullable();
            $table->string('conversionTime')->nullable();
            $table->string('conversionValue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_ads_datas');
    }
};
