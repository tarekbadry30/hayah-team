<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationHelpTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_help_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc')->nullable();
            $table->foreignId("donation_help_id")->references("id")->on("donation_helps")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('locale')->index();
            $table->unique(['donation_help_id','locale']);

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
        Schema::dropIfExists('donation_help_translations');
    }
}
