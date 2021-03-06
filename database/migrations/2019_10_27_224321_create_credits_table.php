<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('seller_id');
            $table->date('expiration_date');
            $table->unsignedDecimal('money', 20, 2);
            $table->unsignedDecimal('interest_rate');
            $table->unsignedDecimal('profit', 20, 2);
            $table->unsignedDecimal('seller_profit', 20, 2);
            $table->unsignedDecimal('money_to_give', 20, 2)->nullable()->default(null);
            $table->string('period');
            $table->boolean('credit_cancelled')->default(0);
            $table->unsignedInteger('shares_numbers');
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
        Schema::dropIfExists('credits');
    }
}
