<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('venue_id')->unsigned()->nullable();
            $table->foreign('venue_id')->references('id')->on('venues');
            $table->text('eventName');
            $table->text('description');
            $table->date('event_date');
            $table->integer('participants');
            $table->text('target_dept');
            $table->text('status');
            $table->integer('dept_head')->unsigned()->nullable();
            $table->integer('adaa')->unsigned()->nullable();
            $table->integer('atty')->unsigned()->nullable();
            $table->integer('osa')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
