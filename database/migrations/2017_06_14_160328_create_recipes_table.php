<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->string('id');
            $table->timestamps();
            $table->string('html');
            $table->string('url');
            $table->string('text');
            $table->string('logo');
            $table->string("name");
            $table->string('yield');
            $table->string('totalTime');
            $table->integer('totalTimeInSeconds');
            $table->integer('numberOfServings');
            $table->double('salty', 20, 19);
            $table->double('meaty', 20, 19);
            $table->double('piquant', 20, 19);
            $table->double('bitter', 20, 19);
            $table->double('sour', 20, 19);
            $table->double('sweet', 20, 19);
            $table->string('sourceRecipeUrl');
            $table->string('sourceSiteUrl');
            $table->string('sourceDisplayName');
            $table->string('hostedLargeUrl');
            $table->string('hostedMediumUrl');
            $table->string('hostedSmallUrl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
