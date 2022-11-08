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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('status')->default(true);
            $table->string('bank_name')->nullable();
            $table->string('rnc')->nullable();
            $table->string('email');
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('address');
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
        Schema::dropIfExists('insurances');
    }
};
