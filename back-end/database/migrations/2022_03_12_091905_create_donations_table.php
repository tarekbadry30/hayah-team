<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            //$table->string('name');
            $table->text('desc');
            $table->text('lat')->nullable();
            $table->text('long')->nullable();
            $table->text('address')->nullable();
            $table->enum('status',['pending','admin_refused','assigned','delivery_accepted','delivery_refused','completed'])->default('pending');
            //$table->enum('type',['financial','physical'])->default('financial');
            //$table->double('value')->nullable();
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
        Schema::dropIfExists('donations');
    }
}
