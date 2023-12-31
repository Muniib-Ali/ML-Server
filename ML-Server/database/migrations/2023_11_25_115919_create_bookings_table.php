<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_group_id');
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('user_id');
            $table->text('resource_name');
            $table->date('start_date');
            $table->integer('start_time');
            $table->date('end_date');
            $table->integer('end_time');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('resource_group_id')->references('id')->on('resource_group');
            $table->foreign('resource_id')->references('id')->on('resource');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }

};
