<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_ideas', function (Blueprint $table) {
            $table->id();
            $table->string('idea');
            $table->string('target_group');
            $table->text('execution_mechanism');
            $table->string('name');
            $table->string('phone');
            $table->string('money');
            $table->string('timing');

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
        Schema::dropIfExists('share_ideas');
    }
}
