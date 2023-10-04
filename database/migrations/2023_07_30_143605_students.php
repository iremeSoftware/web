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
            //
            $table->id();
            $table->string('school_id');
            $table->string('student_id')->unique();
            $table->string('name');
            $table->string('sex');
            $table->string('class_id');
            $table->string('dob');
            $table->string('location');
            $table->string('registered_by');
            $table->string('parent_id');
            $table->integer('is_enabled');
            $table->integer('is_deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
