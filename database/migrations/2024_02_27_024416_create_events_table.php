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
            $table->integer('room_id')->unsigned()->nullable();
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->text('event_name');
            $table->text('description');
            $table->enum('type', ['whole_day', 'within_day', 'whole_week']);
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('participants');
            $table->integer('target_dept')->unsigned()->nullable();
            $table->foreign('target_dept')->references('id')->on('departments');
            $table->integer('target_org')->unsigned()->nullable();
            $table->foreign('target_org')->references('id')->on('organizations');
            $table->string('event_letter')->default('default.pdf')->nullable();
            $table->string('feedback_image')->nullable();
            $table->string('receipt_image')->nullable();
            $table->text('status');
            $table->string('org_adviser')->nullable();
            $table->timestamp('approved_org_adviser_at')->nullable();
            $table->string('remarks_org_adviser')->nullable();
            $table->string('sect_head')->nullable();
            $table->timestamp('approved_sec_head_at')->nullable();
            $table->string('remarks_sec_head')->nullable();
            $table->string('dept_head')->nullable();
            $table->timestamp('approved_dept_head_at')->nullable();
            $table->string('remarks_dept_head')->nullable();
            $table->string('osa')->nullable();
            $table->timestamp('approved_osa_at')->nullable();
            $table->string('remarks_osa')->nullable();
            $table->string('adaa')->nullable();
            $table->timestamp('approved_adaa_at')->nullable();
            $table->string('remarks_adaa')->nullable();
            $table->string('atty')->nullable();
            $table->timestamp('approved_atty_at')->nullable();
            $table->string('remarks_atty')->nullable();
            $table->string('campus_director')->nullable();
            $table->timestamp('approved_campus_director_at')->nullable();
            $table->string('remarks_campus_director')->nullable();
            $table->integer('rejected_by')->unsigned()->nullable();
            $table->foreign('rejected_by')->references('id')->on('users');
            $table->string('remarks_business_manager')->nullable();
            $table->text('color');
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
