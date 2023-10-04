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
        Schema::create('academic_Year', function (Blueprint $table) {
            //
            $table->id();
            $table->string('academic_year');
            $table->date('term1_from');
            $table->date('term1_to');
            $table->date('term2_from');
            $table->date('term2_to');
            $table->date('term3_from');
            $table->date('term3_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_Year', function (Blueprint $table) {
            //
        });
    }
};
