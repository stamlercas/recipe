<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('id');
            $table->timestamps();
            $table->string('shortDescription');
            $table->string('longDescription');
            $table->string('searchValue');
            $table->string('type');
        });

        // Insert some stuff
        //$allergies = array('Dairy', 'Egg', 'Gluten', 'Peanut', 'Seafood', 'Sesame', 'Soy', 'Sulfite', 'Tree Nut', 'Wheat');
        $courses = json_decode('[{"id":"course-Main Dishes","name":"Main Dishes","type":"course","description":"Main Dishes","searchValue":"course^course-Main Dishes","localesAvailableIn":["en-US"]},{"id":"course-Desserts","name":"Desserts","type":"course","description":"Desserts","searchValue":"course^course-Desserts","localesAvailableIn":["en-US"]},{"id":"course-Side Dishes","name":"Side Dishes","type":"course","description":"Side Dishes","searchValue":"course^course-Side Dishes","localesAvailableIn":["en-US"]},{"id":"course-Appetizers","name":"Appetizers","type":"course","description":"Appetizers","searchValue":"course^course-Appetizers","localesAvailableIn":["en-US"]},{"id":"course-Salads","name":"Salads","type":"course","description":"Salads","searchValue":"course^course-Salads","localesAvailableIn":["en-US"]},{"id":"course-Breakfast and Brunch","name":"Breakfast and Brunch","type":"course","description":"Breakfast and Brunch","searchValue":"course^course-Breakfast and Brunch","localesAvailableIn":["en-US"]},{"id":"course-Breads","name":"Breads","type":"course","description":"Breads","searchValue":"course^course-Breads","localesAvailableIn":["en-US"]},{"id":"course-Soups","name":"Soups","type":"course","description":"Soups","searchValue":"course^course-Soups","localesAvailableIn":["en-US"]},{"id":"course-Beverages","name":"Beverages","type":"course","description":"Beverages","searchValue":"course^course-Beverages","localesAvailableIn":["en-US"]},{"id":"course-Condiments and Sauces","name":"Condiments and Sauces","type":"course","description":"Condiments and Sauces","searchValue":"course^course-Condiments and Sauces","localesAvailableIn":["en-US"]},{"id":"course-Cocktails","name":"Cocktails","type":"course","description":"Cocktails","searchValue":"course^course-Cocktails","localesAvailableIn":["en-US"]},{"id":"course-Snacks","name":"Snacks","type":"course","description":"Snacks","searchValue":"course^course-Snacks","localesAvailableIn":["en-US"]},{"id":"course-Lunch","name":"Lunch","type":"course","description":"Lunch","searchValue":"course^course-Lunch","localesAvailableIn":["en-US"]}]');
        foreach ($courses as $course) {
            DB::table('courses')->insert(
                array(
                    'id' => $course->id,
                    'shortDescription' => $course->shortDescription,
                    'longDescription' => $course->longDescription,
                    'searchValue' => $course->searchValue,
                    'type' => $course->type
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
        Schema::dropIfExists('courses');
    }
}
