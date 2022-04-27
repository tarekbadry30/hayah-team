<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationHelpAsksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_help_asks', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            $table->text('lat')->nullable();
            $table->text('long')->nullable();
            $table->text('address')->nullable();
            $table->enum('status',['pending','admin_refused','assigned','delivery_accepted','delivery_refused','in_way','completed'])->default('pending');
            $table->foreignId("user_id")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("donation_help_id")->references("id")->on("donation_helps")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("delivery_id")->nullable()->references("id")->on("deliveries")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("category_id")->nullable()->references("id")->on("categories")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId("type_id")->nullable()->references("id")->on("donation_types")->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('donation_help_asks');
    }
}
