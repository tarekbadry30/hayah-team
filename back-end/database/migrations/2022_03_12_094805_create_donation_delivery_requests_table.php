<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationDeliveryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_delivery_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['pending','delivery_accepted','delivery_refused','in_way','completed'])->default('pending');
            $table->foreignId("request_id")->references("id")->on("donation_requests")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("delivery_id")->references("id")->on("deliveries")->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('donation_delivery_requests');
    }
}
