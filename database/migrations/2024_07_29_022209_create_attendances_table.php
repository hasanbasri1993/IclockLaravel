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
        Schema::create('checkinout', function (Blueprint $table) {
            $table->id();
            $table->string('sn')->index('sn_index');
            $table->integer('employee_id')->index('employee_index');
            $table->dateTime('checktime');
            $table->boolean('checktype');
            $table->boolean('verifycode');
            $table->string('sensorid', 5)->nullable();
            $table->string('WorkCode', 20);
            $table->string('Reserved', 20);
            $table->string('stamp');
            $table->timestamps();
            $table->unique(['sn', 'employee_id', 'checktime', 'checktype'], 'unique_checkinout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkinout');
    }
};
