<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id')->references('id')->on('insurances');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('phone_number', 20)->nullable();
            $table->boolean('status')->default(true);
            $table->string('identification')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurers');
    }
};
