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
            $table->string('item')->unsigned();
            $table->string('addinstruct')->unsigned();
            $table->string('price')->unsigned();
            $table->string('shoplocation')->unsigned();
            $table->varchar('shoplat')->unsigned();
            $table->varchar('shoplng')->unsigned();
            $table->string('deliverylocation')->unsigned();
            $table->varchar('deliverylat')->unsigned();
            $table->varchar('deliverylng')->unsigned();
            $table->integer('status')->unsigned();
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
