<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_sheets', function (Blueprint $table) {
            $table->id();
            $table->boolean('visible')->default(true);
            $table->dateTime('from')->nullable();
            $table->dateTime('to')->nullable();
            $table->enum('user_type',['all','benefactor','needy'])->default('all');

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
        Schema::dropIfExists('form_sheets');
    }
}
