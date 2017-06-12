<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDietsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('shortDescription');
            $table->string('longDescription');
            $table->string('searchValue');
            $table->string('type');
        });

        // Insert some stuff
        //$allergies = array('Dairy', 'Egg', 'Gluten', 'Peanut', 'Seafood', 'Sesame', 'Soy', 'Sulfite', 'Tree Nut', 'Wheat');
        $diets = '[{"id":"388","shortDescription":"Lacto vegetarian","longDescription":"Lacto vegetarian","searchValue":"388^Lacto vegetarian","type":"diet","localesAvailableIn":["en-US"]},{"id":"389","shortDescription":"Ovo vegetarian","longDescription":"Ovo vegetarian","searchValue":"389^Ovo vegetarian","type":"diet","localesAvailableIn":["en-US"]},{"id":"390","shortDescription":"Pescetarian","longDescription":"Pescetarian","searchValue":"390^Pescetarian","type":"diet","localesAvailableIn":["en-US"]},{"id":"386","shortDescription":"Vegan","longDescription":"Vegan","searchValue":"386^Vegan","type":"diet","localesAvailableIn":["en-US"]},{"id":"387","shortDescription":"Lacto-ovo vegetarian","longDescription":"Vegetarian","searchValue":"387^Lacto-ovo vegetarian","type":"diet","localesAvailableIn":["en-US"]},{"id":"403","shortDescription":"Paleo","longDescription":"Paleo","searchValue":"403^Paleo","type":"diet","localesAvailableIn":["en-US"]}]';
        foreach ($diets as $diet) {
            DB::table('diets')->insert(
                array(
                    'id' => $diet->id,
                    'shortDescription' => $diet->shortDescription,
                    'longDescription' => $diet->longDescription,
                    'searchValue' => $diet->searchValue,
                    'type' => $diet->type
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
        Schema::dropIfExists('diets');
    }
}