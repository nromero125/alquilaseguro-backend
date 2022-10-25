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
    public function up(): void
    {
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_estate_id')->references('id')->on('real_estates');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('phone_number', 20)->nullable();
            $table->boolean('status')->default(true);
            $table->string('identification')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers');
    }
};
