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
        Schema::create('device_cmds', function (Blueprint $table) {
            $table->id();
            $table->string('SN', 20);
            $table->foreign('SN')->references('SN')->on('devices')->onDelete('cascade');
            $table->integer('CmdOrder');
            $table->longText('CmdContent');
            $table->dateTime('CmdCommitTime');
            $table->dateTime('CmdTransTime');
            $table->dateTime('CmdOverTime');
            $table->integer('CmdReturn');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_cmds');
    }
};
