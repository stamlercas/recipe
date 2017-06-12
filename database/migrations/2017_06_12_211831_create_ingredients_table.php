<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('shortDescription');
            $table->string('longDescription');
            $table->string('searchValue');
            $table->string('type');
        });

        // Insert some stuff
        //$allergies = array('Dairy', 'Egg', 'Gluten', 'Peanut', 'Seafood', 'Sesame', 'Soy', 'Sulfite', 'Tree Nut', 'Wheat');
        $ingredients = json_decode(file_get_contents(storage_path() . "/app/json/" . "ingredients.json"));
        foreach ($ingredient as $ingredient) {
            DB::table('ingredients')->insert(
                array(
                    'searchValue' => $ingredient->searchValue,
                    'description' => $ingredient->description,
                    'term' => $ingredient->term
                )
            );
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
