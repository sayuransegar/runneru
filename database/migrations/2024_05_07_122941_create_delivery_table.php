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
        Schema::create('delivery', function (Blueprint $table) {
            $table->id();
            $table->foreign('userid')->references('id')->on('users')->nullable();
            $table->foreign('runnerid')->references('id')->on('runner')->nullable();
            $table->string('item')->nullable();
            $table->string('addinstruct')->nullable();
            $table->string('price')->nullable();
            $table->string('shoplocation')->nullable();
            $table->varchar('shoplat')->nullable();
            $table->varchar('shoplng')->nullable();
            $table->string('deliverylocation')->nullable();
            $table->varchar('deliverylat')->nullable();
            $table->varchar('deliverylng')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
