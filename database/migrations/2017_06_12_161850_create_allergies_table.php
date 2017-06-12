<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('shortDescription');
            $table->string('longDescription');
            $table->string('searchValue');
            $table->string('type');
        });

        // Insert some stuff
        //$allergies = array('Dairy', 'Egg', 'Gluten', 'Peanut', 'Seafood', 'Sesame', 'Soy', 'Sulfite', 'Tree Nut', 'Wheat');
        $allergies = json_decode('[{"id":"393","shortDescription":"Gluten-Free","longDescription":"Gluten-Free","searchValue":"393^Gluten-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"394","shortDescription":"Peanut-Free","longDescription":"Peanut-Free","searchValue":"394^Peanut-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"398","shortDescription":"Seafood-Free","longDescription":"Seafood-Free","searchValue":"398^Seafood-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"399","shortDescription":"Sesame-Free","longDescription":"Sesame-Free","searchValue":"399^Sesame-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"400","shortDescription":"Soy-Free","longDescription":"Soy-Free","searchValue":"400^Soy-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"396","shortDescription":"Dairy-Free","longDescription":"Dairy-Free","searchValue":"396^Dairy-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"397","shortDescription":"Egg-Free","longDescription":"Egg-Free","searchValue":"397^Egg-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"401","shortDescription":"Sulfite-Free","longDescription":"Sulfite-Free","searchValue":"401^Sulfite-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"395","shortDescription":"Tree Nut-Free","longDescription":"Tree Nut-Free","searchValue":"395^Tree Nut-Free","type":"allergy","localesAvailableIn":["en-US"]},{"id":"392","shortDescription":"Wheat-Free","longDescription":"Wheat-Free","searchValue":"392^Wheat-Free","type":"allergy","localesAvailableIn":["en-US"]}]');
        foreach ($allergies as $allergy) {
            DB::table('allergies')->insert(
                array(
                    'id' => $allergy->id,
                    'shortDescription' => $allergy->shortDescription,
                    'longDescription' => $allergy->longDescription,
                    'searchValue' => $allergy->searchValue,
                    'type' => $allergy->type
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
        Schema::dropIfExists('allergies');
    }
}
