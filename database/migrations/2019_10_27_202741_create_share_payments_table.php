<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('share_id')->unique;
            $table->unsignedDecimal('payment_amount');
            $table->unsignedInteger('temporal_seller')->nullable();
            $table->boolean('fee_cancelled');
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
        Schema::dropIfExists('share_payments');
    }
}
