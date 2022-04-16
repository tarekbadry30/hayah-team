<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->text('about');
            $table->text('vision');
            $table->text('goals');
            $table->string('locale')->index();
            $table->foreignId("setting_id")->references("id")->on("settings")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['setting_id','locale']);

           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
}
