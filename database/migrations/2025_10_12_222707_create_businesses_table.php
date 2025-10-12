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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 510)->nullable();
            $table->unsignedBigInteger('business_category_id');
            $table->geography('coordinates', subtype: 'point', srid: 4326)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_category_id')->references('id')->on('business_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
