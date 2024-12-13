<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceLogTable extends Migration
{
    public function up(): void
    {
        Schema::create('devlogs', function (Blueprint $table) {
            $table->id();
            $table->string('SN', 20);
            $table->string('OP', 8);
            $table->string('Object', 20);
            $table->string('Cnt', 20);
            $table->string('ECnt', 20);
            $table->datetime('OpTime');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devlogs');
    }
}
