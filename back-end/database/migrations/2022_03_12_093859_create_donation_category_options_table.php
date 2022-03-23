<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationCategoryOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_category_options', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->foreignId("option_id")->references("id")->on("category_options")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("donation_id")->references("id")->on("donations")->cascadeOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('donation_category_options');
    }
}
