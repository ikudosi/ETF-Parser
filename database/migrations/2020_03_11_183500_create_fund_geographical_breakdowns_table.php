<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundGeographicalBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_geographical_breakdowns', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('fund_id')->unsigned();
            $table->string('country_name');
            $table->decimal('weight');
            $table->timestamps();

            $table->foreign('fund_id')->references('id')->on('funds')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_geographical_breakdowns');
    }
}
