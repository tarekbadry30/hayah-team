<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_types', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->enum('status',['enabled','disabled'])->default('enabled');
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
        Schema::dropIfExists('donation_types');
    }
}
