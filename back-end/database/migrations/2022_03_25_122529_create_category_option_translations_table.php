<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryOptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_option_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId("option_id")->references("id")->on("category_options")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('locale')->index();
            $table->unique(['option_id','locale']);
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
        Schema::dropIfExists('category_option_translations');
    }
}
