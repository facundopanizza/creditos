<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('credit_id')->nullable()->default(null);
            $table->unsignedInteger('sharePayment_id')->nullable()->default(null);
            $table->unsignedInteger('cashAllocation_id')->nullable()->default(null);
            $table->unsignedDecimal('money', 20, 2);
            $table->string('description')->nullable()->default(null);
            $table->string('picture')->nullable()->default(null);
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
        Schema::dropIfExists('expenses');
    }
}
