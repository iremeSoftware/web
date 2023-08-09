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
        Schema::create('school_registration_requests', function (Blueprint $table) {
            //
            $table->id();
            $table->string('request_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('school_name');
            $table->string('scale');
            $table->integer('is_deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_registration_requests', function (Blueprint $table) {
            //
        });
    }
};
