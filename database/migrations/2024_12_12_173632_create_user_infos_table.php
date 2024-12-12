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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('userid');
            $table->string('badgenumber', 20);
            $table->integer('defaultdeptid')->nullable();
            $table->string('name', 40)->nullable();
            $table->string('Password', 20)->nullable();
            $table->string('Card', 20)->nullable();
            $table->integer('Privilege')->nullable();
            $table->integer('AccGroup')->nullable();
            $table->string('TimeZones', 20)->nullable();
            $table->string('Gender', 2)->nullable();
            $table->dateTime('Birthday')->nullable();
            $table->string('street', 40)->nullable();
            $table->string('zip', 6)->nullable();
            $table->string('ophone', 20)->nullable();
            $table->string('FPHONE', 20)->nullable();
            $table->string('pager', 20)->nullable();
            $table->string('minzu', 8)->nullable();
            $table->string('title', 20)->nullable();
            $table->string('SN', 20)->nullable();
            $table->string('SSN', 20)->nullable();
            $table->dateTime('UTime')->nullable();
            $table->string('State', 2)->nullable();
            $table->string('City', 2)->nullable();
            $table->smallInteger('SECURITYFLAGS')->nullable();
            $table->smallInteger('DelTag');
            $table->integer('RegisterOT')->nullable();
            $table->integer('AutoSchPlan')->nullable();
            $table->integer('MinAutoSchInterval')->nullable();
            $table->integer('Image_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
