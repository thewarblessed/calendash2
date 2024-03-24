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
        Schema::create('outside_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->string('quotation')->nullable();
            $table->text('amount');
            $table->text('reason')->nullable();
            $table->text('status');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outside_events');
    }
};
