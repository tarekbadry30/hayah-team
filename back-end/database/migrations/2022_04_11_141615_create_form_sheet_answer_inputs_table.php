<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSheetAnswerInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_sheet_answer_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("form_sheet_id")->references("id")->on("form_sheets")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("input_id")->references("id")->on("form_sheet_inputs")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("answer_id")->references("id")->on("form_sheet_user_answers")->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('answer');
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
        Schema::dropIfExists('form_sheet_answer_inputs');
    }
}
