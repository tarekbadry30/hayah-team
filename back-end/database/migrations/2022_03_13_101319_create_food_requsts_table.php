<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodRequstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_requests', function (Blueprint $table) {
            $table->id();
            $table->float('total_value');
            $table->text('notes')->nullable();

            $table->foreignId("user_id")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("delivery_id")->nullable()->references("id")->on("deliveries")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("month_id")->references("id")->on("user_month_helps")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("admin_id")->nullable()->references("id")->on("admins")->nullOnDelete()->cascadeOnUpdate();
            $table->enum('status',['pending','admin_refused','assigned','delivery_accepted','delivery_refused','in_way','completed'])->default('pending');
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
        Schema::dropIfExists('food_requests');
    }
}
