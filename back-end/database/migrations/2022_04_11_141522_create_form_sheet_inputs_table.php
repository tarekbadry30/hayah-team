<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSheetInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_sheet_inputs', function (Blueprint $table) {
            $table->id();
            //$table->string('name');
            $table->foreignId("form_sheet_id")->references("id")->on("form_sheets")->cascadeOnDelete()->cascadeOnUpdate();
            //$table->string('locale')->index();
            //$table->unique(['form_sheet_id','locale']);
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
        Schema::dropIfExists('form_sheet_inputs');
    }
}
