<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeSearchesNutritionAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_searches_nutrition_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recipe_search_id');
            $table->integer('nutrition_attribute_id');
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
