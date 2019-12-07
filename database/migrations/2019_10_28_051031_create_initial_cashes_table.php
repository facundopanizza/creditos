<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initial_cashes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedDecimal('entry_money', 20, 2);
            $table->unsignedDecimal('money', 20, 2);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('closeDay_id')->nullable()->default(null);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('initial_cashes');
    }
}
