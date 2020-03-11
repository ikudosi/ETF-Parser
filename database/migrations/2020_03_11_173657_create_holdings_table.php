<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('holdings', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('fund_id')->unsigned();
            $table->string('name');
            $table->integer('shares_held');
            $table->decimal('weight');
            $table->timestamps();

            $table->foreign('fund_id')->references('id')->on('funds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holdings');
        Schema::dropIfExists('funds');
    }
}
