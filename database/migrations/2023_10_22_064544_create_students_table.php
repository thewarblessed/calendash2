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
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->text('tupID');
            $table->text('lastname');
            $table->text('firstname');
            $table->text('course');
            $table->text('department');
            $table->text('studOrg');
            $table->text('yearlevel');
            $table->text('section');
            $table->text('role');
            $table->string('image')->default('student.jpg');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
