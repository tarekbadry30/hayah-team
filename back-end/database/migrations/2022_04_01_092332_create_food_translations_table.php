<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc')->nullable();
            $table->foreignId("food_id")->references("id")->on("food")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('locale')->index();
            $table->unique(['food_id','locale']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_translations');
    }
}
