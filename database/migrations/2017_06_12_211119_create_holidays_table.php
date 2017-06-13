<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->string('id');
            $table->timestamps();
            $table->string('name');
            $table->string('type');
            $table->string('description');
            $table->string('searchValue');
        });

        // Insert some stuff
        //$allergies = array('Dairy', 'Egg', 'Gluten', 'Peanut', 'Seafood', 'Sesame', 'Soy', 'Sulfite', 'Tree Nut', 'Wheat');
        $holidays = json_decode('[{"id":"holiday-christmas","name":"Christmas","type":"holiday","description":"Christmas","searchValue":"holiday^holiday-christmas","localesAvailableIn":["en-US"]},{"id":"holiday-thanksgiving","name":"Thanksgiving","type":"holiday","description":"Thanksgiving","searchValue":"holiday^holiday-thanksgiving","localesAvailableIn":["en-US"]},{"id":"holiday-summer","name":"Summer","type":"holiday","description":"Summer","searchValue":"holiday^holiday-summer","localesAvailableIn":["en-US"]},{"id":"holiday-fall","name":"Fall","type":"holiday","description":"Fall","searchValue":"holiday^holiday-fall","localesAvailableIn":["en-US"]},{"id":"holiday-new-year","name":"New Year","type":"holiday","description":"New Year","searchValue":"holiday^holiday-new-year","localesAvailableIn":["en-US"]},{"id":"holiday-super-bowl","name":"Game Day","type":"holiday","description":"Game Day","searchValue":"holiday^holiday-super-bowl","localesAvailableIn":["en-US"]},{"id":"holiday-winter","name":"Winter","type":"holiday","description":"Winter","searchValue":"holiday^holiday-winter","localesAvailableIn":["en-US"]},{"id":"holiday-spring","name":"Spring","type":"holiday","description":"Spring","searchValue":"holiday^holiday-spring","localesAvailableIn":["en-US"]},{"id":"holiday-halloween","name":"Halloween","type":"holiday","description":"Halloween","searchValue":"holiday^holiday-halloween","localesAvailableIn":["en-US"]},{"id":"holiday-valentines-day","name":"Valentine\'s Day","type":"holiday","description":"Valentine\'s Day","searchValue":"holiday^holiday-valentines-day","localesAvailableIn":["en-US"]},{"id":"holiday-hanukkah","name":"Hanukkah","type":"holiday","description":"Hanukkah","searchValue":"holiday^holiday-hanukkah","localesAvailableIn":["en-US"]},{"id":"holiday-passover","name":"Passover","type":"holiday","description":"Passover","searchValue":"holiday^holiday-passover","localesAvailableIn":["en-US"]},{"id":"holiday-easter","name":"Easter","type":"holiday","description":"Easter","searchValue":"holiday^holiday-easter","localesAvailableIn":["en-US"]},{"id":"holiday-st-patricks-day","name":"St. Patrick\'s Day","type":"holiday","description":"St. Patrick\'s Day","searchValue":"holiday^holiday-st-patricks-day","localesAvailableIn":["en-US"]},{"id":"holiday-chinese-new-year","name":"Chinese New Year","type":"holiday","description":"Chinese New Year","searchValue":"holiday^holiday-chinese-new-year","localesAvailableIn":["en-US"]},{"id":"holiday-4th-of-july","name":"4th of July","type":"holiday","description":"4th of July","searchValue":"holiday^holiday-4th-of-july","localesAvailableIn":["en-US"]}]');
        foreach ($holidays as $holiday) {
            DB::table('holidays')->insert(
                array(
                    'id' => $holiday->id,
                    'name'=> $holiday->name,
                    'type' => $holiday->type,
                    'description' => $holiday->description,
                    'searchValue' => $holiday->searchValue
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
        Schema::dropIfExists('holidays');
    }
}