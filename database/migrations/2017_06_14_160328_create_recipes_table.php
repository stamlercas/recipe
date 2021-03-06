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
            $table->text('html');
            $table->string('url');
            $table->string('text');
            $table->string('logo');
            $table->string("name");
            $table->string('yield')->nullable();
            $table->string('totalTime');
            $table->integer('totalTimeInSeconds');
            $table->integer('numberOfServings');
            $table->double('salty', 20, 19)->nullable();
            $table->double('meaty', 20, 19)->nullable();
            $table->double('piquant', 20, 19)->nullable();
            $table->double('bitter', 20, 19)->nullable();
            $table->double('sour', 20, 19)->nullable();
            $table->double('sweet', 20, 19)->nullable();
            $table->string('sourceRecipeUrl');
            $table->string('sourceSiteUrl');
            $table->string('sourceDisplayName');
            $table->string('hostedLargeUrl')->nullable();
            $table->string('hostedMediumUrl')->nullable();
            $table->string('hostedSmallUrl')->nullable();
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
