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
        Schema::create('myevents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['whole_day', 'within_day', 'whole_week']);
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('whole_week')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('myevents');
    }
};
