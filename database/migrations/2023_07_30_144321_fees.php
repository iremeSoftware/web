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
        Schema::create('fees_partitions', function (Blueprint $table) {
            //
            $table->id();
            $table->string('school_id');
            $table->string('class_id');
            $table->string('fees_id');
            $table->string('student_id');
            $table->string('term');
            $table->integer('amount');
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
        Schema::table('fees_partitions', function (Blueprint $table) {
            //
        });
    }
};
