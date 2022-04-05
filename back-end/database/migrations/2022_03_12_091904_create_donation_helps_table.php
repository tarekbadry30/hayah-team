<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_helps', function (Blueprint $table) {
            $table->id();
            $table->boolean('available')->default(true);
            $table->boolean('asked')->default(false);
            $table->string('img')->nullable();
            $table->foreignId("type_id")->nullable()->references("id")->on("donation_types")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("category_id")->nullable()->references("id")->on("categories")->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('donation_helps');
    }
}
