<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundIndexSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_index_sectors', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('fund_id')->unsigned();
            $table->string('name');
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
        Schema::dropIfExists('fund_index_sectors');
    }
}
