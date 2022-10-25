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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('broker_id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('real_estate_id');
            $table->dateTime('payment_due_date');
            $table->text('description');
            $table->string('code');
            $table->string('address');
            $table->tinyInteger('status');
            $table->decimal('monthly_payment');
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
        Schema::dropIfExists('properties');
    }
};
