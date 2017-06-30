<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrition_estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attribute');
            $table->string('description')->nullable();
            $table->string('value');
            $table->string('unit_name');
            $table->string('unit_abbreviation');
            $table->string('unit_plural');
            $table->string('unit_plural_abbreviation');
            $table->string('recipe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nutrition_estimates');
    }
}
