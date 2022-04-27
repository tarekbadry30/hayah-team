<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_donations', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['error','completed'])->default('completed');
            $table->double('value');
            $table->text('operation_id');
            $table->foreignId("option_id")->nullable()->references("id")->on("category_options")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("admin_id")->nullable()->references("id")->on("admins")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("type_id")->nullable()->references("id")->on("donation_types")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("category_id")->nullable()->references("id")->on("categories")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("user_id")->nullable()->references("id")->on("users")->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('finance_donations');
    }
}
