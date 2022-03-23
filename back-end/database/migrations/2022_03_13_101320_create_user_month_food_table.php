<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMonthFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_month_food', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("delivery_id")->references("id")->on("deliveries")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("month_id")->references("id")->on("user_month_helps")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("food_id")->references("id")->on("user_month_helps")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("request_id")->references("id")->on("food_requests")->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('price');

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
        Schema::dropIfExists('user_month_food');
    }
}
