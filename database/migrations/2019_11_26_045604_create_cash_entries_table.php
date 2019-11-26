<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('initialCash_id');
            $table->unsignedDecimal('money', 20, 2);
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
        Schema::dropIfExists('cash_entries');
    }
}
