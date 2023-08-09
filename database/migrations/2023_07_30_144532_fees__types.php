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
        Schema::create('fees_types', function (Blueprint $table) {
            //
            $table->id();
            $table->string('school_id');
            $table->string('fees_id');
            $table->string('fees_name');
            $table->integer('fees_amount');
            $table->string('class_id');
            $table->string('terms');
            $table->integer('registered_by');
            $table->integer('is_required');
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
        Schema::table('fees_types', function (Blueprint $table) {
            //
        });
    }
};
