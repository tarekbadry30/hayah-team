<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_options', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['enabled','disabled'])->default('enabled');
            $table->boolean('accept_any_value')->default(true);
            $table->string('default_value')->nullable();
            $table->foreignId("category_id")->nullable()->references("id")->on("categories")->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('category_options');
    }
}
