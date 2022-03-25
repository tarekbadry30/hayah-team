<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['enabled','disabled'])->default('enabled');
            $table->string('img');
            $table->foreignId("parent_id")->nullable()->references("id")->on("categories")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("admin_id")->nullable()->references("id")->on("admins")->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('categories');
    }
}
