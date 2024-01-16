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
            $table->text('event_name');
            $table->text('description');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('participants');
            $table->text('target_dept');
            $table->string('event_letter')->default('default.pdf');
            $table->text('status');
            $table->string('sect_head')->nullable();
            $table->string('dept_head')->nullable();
            $table->string('osa')->nullable();
            $table->string('adaa')->nullable();
            $table->string('atty')->nullable();
            $table->string('campus_director')->nullable();
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
