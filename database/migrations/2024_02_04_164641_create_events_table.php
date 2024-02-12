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
            $table->string('org_adviser')->nullable();
            $table->timestamp('approved_org_adviser_at')->nullable();
            $table->string('sect_head')->nullable();
            $table->timestamp('approved_sec_head_at')->nullable();
            $table->string('dept_head')->nullable();
            $table->timestamp('approved_dept_head_at')->nullable();
            $table->string('osa')->nullable();
            $table->timestamp('approved_osa_at')->nullable();
            $table->string('adaa')->nullable();
            $table->timestamp('approved_adaa_at')->nullable();
            $table->string('atty')->nullable();
            $table->timestamp('approved_atty_at')->nullable();
            $table->string('campus_director')->nullable();
            $table->timestamp('approved_campus_director_at')->nullable();
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
