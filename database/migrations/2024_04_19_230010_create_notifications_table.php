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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('to_user_id')->unsigned()->nullable();
            $table->foreign('to_user_id')->references('id')->on('users');
            $table->string('subject');
            $table->text('message');
            $table->integer('from_user_id')->unsigned()->nullable();
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
