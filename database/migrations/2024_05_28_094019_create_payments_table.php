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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreign('runnerid')->references('id')->on('runners')->nullable();
            $table->foreign('userid')->references('id')->on('users')->nullable();
            $table->foreign('deliveryid')->references('id')->on('deliveries')->nullable();
            $table->decimal('itemprice', 8, 2)->nullable();
            $table->decimal('servicecharge', 8, 2)->nullable();
            $table->varchar('receipt')->nullable(); //will be enter by customer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
