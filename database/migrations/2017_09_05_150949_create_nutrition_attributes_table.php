<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrition_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->string('description');
            $table->string('units');
            $table->timestamps();
        });

        $nutrition_attributes = json_decode('
        [
            {
                "value": "K", 
                "description": "Potassium, K", 
                "units": "gram"
            },
            {
                "value": "NA", 
                "description": "Sodium, NA", 
                "units": "gram"
            },
            {
                "value": "CHOLE", 
                "description": "Cholestrol", 
                "units": "gram"
            },
            {
                "value": "FATRN", 
                "description": "Fatty acids, total trans", 
                "units": "gram"
            },
            {
                "value": "FASAT", 
                "description": "Fatty acids, total saturated", 
                "units": "gram"
            },
            {
                "value": "CHOCDF", 
                "description": "Carbohydrate, by difference", 
                "units": "gram"
            },
            {
                "value": "FIBTG", 
                "description": "Fiber, total dietary", 
                "units": "gram"
            },
            {
                "value": "PROCNT", 
                "description": "Protein", 
                "units": "gram"
            },
            {
                "value": "VITC", 
                "description": "Vitamin C, total ascorbic acid", 
                "units": "gram"
            },
            {
                "value": "CA", 
                "description": "Calcium, Ca", 
                "units": "gram"
            },
            {
                "value": "FE", 
                "description": "Iron, Fe", 
                "units": "gram"
            },
            {
                "value": "SUGAR", 
                "description": "Sugars, total", 
                "units": "gram"
            },
            {
                "value": "ENERC_KCAL", 
                "description": "Energy", 
                "units": "kcal"
            },
            {
                "value": "FAT", 
                "description": "Total lipid (fat)", 
                "units": "gram"
            },
            {
                "value": "VITA_IU", 
                "description": "Vitamin A, IU", 
                "units": "IU"
            }
        ]');

        foreach ($nutrition_attributes as $attribute) {
            DB::table('nutrition_attributes')->insert(
                array(
                    'value' => $attribute->value,
                    'description' => $attribute->description,
                    'units' => $attribute->units
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
        Schema::dropIfExists('nutrition_attributes');
    }
}
